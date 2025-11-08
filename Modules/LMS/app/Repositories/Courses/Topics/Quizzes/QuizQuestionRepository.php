<?php

namespace Modules\LMS\Repositories\Courses\Topics\Quizzes;

use Modules\LMS\Enums\QuestionTypes;
use Modules\LMS\Models\Courses\Topics\Quizzes\Answer;
use Modules\LMS\Models\Courses\Topics\Quizzes\Question;
use Modules\LMS\Models\Courses\Topics\Quizzes\QuestionAnswer;
use Modules\LMS\Models\Courses\Topics\Quizzes\QuizQuestion;
use Modules\LMS\Repositories\BaseRepository;

class QuizQuestionRepository extends BaseRepository
{
    protected static $model = QuizQuestion::class;
    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'title' => 'required',
            'mark' => 'required',
            'question_type' => 'required',
            'quiz_id' => 'required',
        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['answers', '_token', 'title', 'search_terms'],
        'update' => ['answers', '_token', 'title', 'search_terms', 'quiz_id'],
    ];

    /**
     * save
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        $response = [];

        // Check for image and video uploads.
        $requestType = null;

        if ($request->hasFile('image')) {
            $requestType = 'image';
        } elseif ($request->hasFile('video')) {
            $requestType = 'video';
        }

        // Determine which file type is being uploaded and set rules accordingly.
        match ($requestType) {
            'image' => static::$rules['save'] = 'required|image|mimes:jpg,svg,jpeg,png,webp',
            'video' => static::$rules['save'] = 'required|file|mimes:mp4,mov,ogg,qt|max:20000',
            default => null,
        };

        // Upload the file if one is provided.
        if ($requestType) {
            $file = parent::upload($request, fieldname: $requestType, file: '', folder: 'lms/quizzes');
            $request->request->add([$requestType => $file]);
        }

        // Add the question ID if the title is present.
        if ($request->title) {
            $request->request->add([
                'question_id' => self::questionSave($request->title),
            ]);
        }

        // Update or save the question based on the presence of an ID.
        if (isset($request->id)) {
            $question = self::update($request->id, $request->all());
            $response = [
                'status' => 'success',
                'message' => translate('Update Successfully.')
            ];
        } else {
            $question = parent::save($request->all());
            $response = [
                'status' => 'success',
                'type' => 'course'
            ];
        }

        // Save the answers if the question was successful.
        if ($question['status'] == 'success') {
            self::questionAnswerSave($question['data']->id, $request->answers, $request->question_type);
            return $response;
        }

        return $question;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        return parent::update($id, $data);
    }

    /**
     *  delete
     *
     * @param  int  $int
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $quizQuestion = static::$model::with('questionAnswers')->where('id', $id)->first();
        if (!$quizQuestion) {
            return [
                'status' => 'error',
                'data' => translate('Something Wrong!'),
            ];
        }

        $quizQuestion->questionAnswers()->delete();
        $quizQuestion->delete();
        return [
            'status' => 'success',
            'type' => 'question',
        ];
    }

    /**
     * questionAnswerSave
     *
     * @param  int  $questionId
     * @param  array  $answers  $answers
     * @param  string  $questionType
     * @return void
     */
    protected static function questionAnswerSave($questionId, $answers, $questionType)
    {
        if (! empty($answers)) {
            QuestionAnswer::where('quiz_question_id', $questionId)->delete();
            if ($questionType == QuestionTypes::FILL_IN_BLANK) {
                $answers = implode(',', $answers);
                $answers = explode(',', $answers);
                foreach ($answers as $answer) {
                    if (isset($answer)) {
                        QuestionAnswer::create(
                            [
                                'answer_id' => self::answerSave($answer),
                                'quiz_question_id' => $questionId,
                            ]
                        );
                    }
                }
            } else {
                foreach ($answers as $answer) {
                    if (isset($answer['name'])) {
                        QuestionAnswer::create(
                            [
                                'answer_id' => self::answerSave($answer['name']),
                                'quiz_question_id' => $questionId,
                                'correct' => isset($answer['correct']) ? ($answer['correct'] == 'on' ? 1 : 0) : 0,
                            ]
                        );
                    }
                }
            }
        }
    }

    /**
     *  questionSave
     *
     * @param  string  $name
     * @return int|null
     */
    protected static function questionSave($name)
    {
        $question = Question::firstWhere('name', $name);
        if (! $question) {
            $question = Question::create([
                'name' => $name,
            ]);
        }
        return $question ? $question->id : '';
    }

    /**
     *  questionSave
     *
     * @param  string  $name
     * @return int|null
     */
    protected static function answerSave($name)
    {
        $answer = Answer::firstWhere('name', $name);
        if (! $answer) {
            $answer = Answer::create([
                'name' => $name,
            ]);
        }

        return $answer ? $answer->id : '';
    }

    public function searchingSuggestion($request)
    {

        return match ($request->search_type) {
            // If search type is 'question', search in modelOne using the 'name' column with a LIKE query

            'question' => Question::where('name', 'like', '%' . $request->key . '%')->get(),

            // If search type is 'answer', search in modelTwo using the 'name' column with a LIKE query

            'answer' => Answer::where('name', 'like', '%' . $request->key . '%')->get(),

                // If the search type doesn't match any of the above cases, return an error response
            default => response()->json(['error' => 'Invalid search type'], 400),
        };
    }

    public function getQuestionByQuizId($id)
    {
        return static::$model::with('question', 'questionAnswers.answer')->where('quiz_id', $id)->orderBy('position')->get();
    }

    /**
     *  quizQuestionSorted
     *
     * @param  mixed  $request
     * @return array
     */
    public function quizQuestionSorted($request)
    {
        if (is_array($request->itemIds)) {
            $position = 0;
            foreach ($request->itemIds as $id) {
                $position++;
                if ($quizQuestion = static::$model::firstWhere('id', $id)) {
                    $quizQuestion->position = $position;
                    $quizQuestion->update();
                }
            }
            return [
                'status' => 'success',
                'data' => translate('Sorted Successfully'),
            ];
        }
        return [
            'status' => 'error',
            'data' => translate('something Wrong!'),
        ];
    }
}
