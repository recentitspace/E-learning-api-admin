<?php

namespace Modules\LMS\Repositories\Exam;

use Modules\LMS\Models\Auth\UserCourseExam;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Repositories\Courses\Topics\Assignment\AssignmentRepository;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuizRepository;

class ExamRepository extends BaseRepository
{
    protected static $model = UserCourseExam::class;

    protected static $assignment;
    protected static $quiz;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'type', 'source', 'file_title'],
        'update' => ['_token', 'type', 'source', 'file_title'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required|string',
            'course_id' => 'required|int',
        ],
        'update' => [],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {

        switch ($request->type) {
            case 'assignment':
                static::$rules['save'] = ['source' => 'required'];

                // Step 1: Prepare necessary request data
                self::prepareRequestData($request);

                // Step 2: Define options for fetching the user's course exam
                $options = self::getExamOptions($request);

                // Step 3: Handle existing exam scenario
                if ($exam = self::userCourseExam($options)) {
                    self::handleExistingExam($exam, $request);
                    return self::update($exam->id, $request->all());
                }
                // Step 4: Handle new exam scenario
                return self::handleNewExam($request);
            default:
                return ['status' => 'error'];
        }
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {

        static::$rules['update'] = [
            'source' => 'required',
        ];
        $updateExam = parent::update($id, $data);

        if ($updateExam['status'] == 'success') {
            $updateExam['data']->update([
                'attempt_number' => $updateExam['data']->attempt_number + 1,
            ]);
        }

        return $updateExam;
    }

    /**
     *  userCourseExam
     *
     * @param  array  $options
     */
    public static function userCourseExam($options)
    {
        if ($userExam = static::$model::with('user', 'sourceFiles', 'assignment')->where($options)->first()) {
            return $userExam;
        }

        return false;
    }

    /**
     *  startExam
     *
     * @param string $type 
     * @param int $id 
     * @param int $courseId 
     * @param mixed $request 
     */
    public static function startExam($type, $id, $courseId, $request)
    {
        // Determine the user ID based on role and request
        $userId = !isInstructor() && !isset($request->student)
            ? authCheck()->id
            : $request->student;

        // Store user ID in session if provided
        if (isset($request->student)) {
            session()->put('user_id', $userId);
        }
        // Validate and process the type
        switch ($type) {
            case 'assignment':
                return self::handleAssignment($id, $courseId, $userId);

            case 'quiz':
                if (isset($request->status) && $request->status == 'start') {
                    static::$model::updateOrCreate(['quiz_id' => $id, 'user_id' => authCheck()->id], [
                        'course_id' => $courseId,
                        'quiz_id' => $id
                    ]);
                }
                return self::handleQuiz($id, $request, $courseId, $userId);

            default:
                return [
                    'status' => 'error',
                    'message' => translate('Invalid type provided')
                ];
        }
    }

    // Helper methods for cleaner logic
    private static function handleAssignment($id, $courseId, $userId)
    {
        $assignment = AssignmentRepository::getById($id, $courseId);

        if (!$assignment) {
            return [
                'status' => 'error',
                'message' => translate('Assignment not found or invalid')
            ];
        }
        $userExam = self::userCourseExam(['assignment_id' => $assignment->id, 'user_id' => $userId]);

        return [
            'status' => 'success',
            'data' => [
                'assignment' => $assignment,
                'userExam' => $userExam ?? null,
                'type' => 'assignment',
            ],
        ];
    }

    private static function handleQuiz($id, $request, $courseId, $userId)
    {
        $response = QuizRepository::first($id, relations: [
            'questions.question',
            'questions.questionScore',
            'questions.questionAnswers.answer',
            'questions.questionAnswers.takeAnswer',
            'topic.chapter.course' => function ($query) {
                $query->select('id', 'title', 'slug');
            }
        ]);
        $quiz = $response['data'] ?? null;

        if (!$quiz || !isset($quiz->questions)) {
            return [
                'status' => 'error',
                'message' => translate('Quiz not found or invalid')
            ];
        }


        $questions = array_chunk($quiz->questions->toArray(), 2, true);
        $userExam = self::userCourseExam(['quiz_id' => $quiz->id, 'user_id' => $userId]);
        return [
            'status' => 'success',
            'data' => [
                'questions' => $questions,
                'userExam' => $userExam ?? null,
                'type' => 'quiz',
                'quiz' => $quiz,
                'chapter_id' => $request->chapter_id ?? null,
                'topic_id' => $request->topic_id ?? null,
                'course_id' => $courseId,
            ],
        ];
    }

    /**
     *  scoreUpdate
     *
     * @param  int  $id  [exam id]
     * @param  mixed  $request
     */
    public function scoreUpdate($id, $request): array
    {
        $userId = session()->get('user_id');
        if ($exam = static::$model::where(['id' => $id, 'user_id' => $userId])->firstOrFail()) {
            $exam->update([
                'score' => $request->score,
            ]);
            session()->forget('user_id');

            return ['status' => 'success'];
        }

        return ['status' => 'error'];
    }

    private static function prepareRequestData(&$request)
    {
        // Add essential attributes to the request
        $request->merge([
            'exam_type' => 'assignment',
            'user_id' => authCheck()->id,
        ]);
    }

    private static function getExamOptions($request)
    {
        // Create and return the options array for fetching user exams
        return [
            'user_id' => $request->user_id,
            'assignment_id' => $request->assignment_id,
        ];
    }

    private static function handleExistingExam($exam, $request)
    {
        // If a source file is uploaded, handle file updates
        if ($request->hasFile('source')) {
            self::updateSourceFiles($exam->id, $request->source,  $request->file_title);
        }
    }

    private static function handleNewExam($request)
    {
        // Add attempt number for the new exam and save
        $request->merge(['attempt_number' => 1]);

        $userExam = parent::save($request->all());

        // Handle file saving for a successfully created exam
        if ($userExam['status'] === 'success') {
            self::saveSourceFiles($request->source, $userExam['data']->id, $request->file_title);
        }

        return $userExam;
    }

    private static function updateSourceFiles($examId, $sourceFiles, $fileName)
    {
        // Delete existing source files and save the new ones
        AssignmentRepository::deleteSource($examId);
        self::saveSourceFiles($sourceFiles, $examId, $fileName);
    }

    private static function saveSourceFiles($sourceFiles, $examId, $fileName)
    {
        // Save source files to the repository
        AssignmentRepository::fileSave(
            assignmentId: null,
            sourceFiles: $sourceFiles,
            examId: $examId,
            fileTile: $fileName
        );
    }
}
