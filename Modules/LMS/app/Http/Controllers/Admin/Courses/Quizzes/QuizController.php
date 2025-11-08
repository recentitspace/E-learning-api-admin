<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses\Quizzes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\Courses\Topics\TopicRepository;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuizRepository;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected QuizRepository $quiz, protected TopicRepository $topic, protected CourseRepository $course,) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $quiz = $this->quiz->save($request->all());
        return response()->json($quiz);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        $quiz = $this->quiz->first($id);

        return response()->json($quiz);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        $quiz = $this->quiz->update($id, $request->all());

        return response()->json($quiz);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $quiz = $this->quiz->delete(id: $id);

        return response()->json($quiz);
    }

    /**
     *  quizStoreResult
     *
     * @param int $id 
     * @param Request $request
     *
     */
    public function quizStoreResult($id, Request $request)
    {
        $this->quiz->finalSubmit($id, $request);

        return redirect()->route('student.quiz.result');
    }

    /**
     * submitQuizAnswer
     *
     * @param  int  $quizId
     * @param  string  $type
     */
    public function submitQuizAnswer($quizId, $type, Request $request)
    {
        return $this->quiz->submitQuizAnswer($quizId, $type, $request);
    }

    /**
     * studentQuizzes
     *
     * @param int $id
     */
    public function quizList(Request $request)
    {
        $request = $request->merge(['instructors' => [authCheck()->id]]);
        $quizzes = $this->topic->getTopicByCourse(coursesId: $this->course->getCoursesId($request), type: 'quiz');
        return view('portal::instructor.quiz.index', compact('quizzes'));
    }

    /**
     * studentQuizzes
     *
     * @param  int  $id
     */
    public function studentQuizzes($id, Request $request)
    {
        $request = $request->merge(['instructors' => [$request->user()->id]]);
        $coursesId = $this->course->getCoursesId($request);
        $quiz = $this->quiz->quizById(id: $id, coursesId: $coursesId);
        $studentQuizzes = $quiz ? $quiz->studentQuizzes()->paginate(10) : [];
        return view('portal::instructor.quiz.student-quiz', compact('quiz', 'studentQuizzes'));
    }
}
