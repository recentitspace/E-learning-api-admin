<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses\Quizzes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuizQuestionRepository;

class QuizQuestionController extends Controller
{
    public function __construct(protected QuizQuestionRepository $quizQuestion) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        //
        $quizQuestions = $this->quizQuestion->get();

        return response()->json($quizQuestions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        //

        $quizQuestion = $this->quizQuestion->save($request);
        if ($quizQuestion['status'] !== 'success') {
            return response()->json($quizQuestion);
        }

        toastr()->success(translate('Question has been saved successfully!'));
        return response()->json($quizQuestion);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        //
        $quizQuestions = $this->quizQuestion->getQuestionByQuizId($id);
        $mode = 'list';
        $quizQuestions = view('portal::admin.course.topic-type.question-list', compact('quizQuestions', 'mode'))->render();

        return response()->json([
            'status' => 'success',
            'data' => $quizQuestions
        ]);
    }

    /**
     * Edit the specified resource.
     */
    public function edit($id)
    {
        $quizQuestion = $this->quizQuestion->first($id, relations: ['question', 'questionAnswers.answer']);
        $quizQuestion = $quizQuestion['data'];
        $mode = 'edit';
        $quizQuestion = view('portal::admin.course.topic-type.question-list', compact('quizQuestion', 'mode'))->render();

        return response()->json(['status' => 'success', 'data' => $quizQuestion]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        //
        $result = $this->quizQuestion->delete($id);

        return response()->json($result);
    }

    /**
     * searchingSuggestion
     */
    public function searchingSuggestion(Request $request)
    {
        $results = $this->quizQuestion->searchingSuggestion($request);
        if (count($results) > 0) {
            $output = '<ul class="search-data dropdown-menu absolute left-0 top-full min-w-40 p-1.5 bg-white text-gray-500 dark:text-dark-text rounded-md border border-input-border shadow-md text-sm divide-y divide-gray-200 dark:divide-dark-border-three z-10">';
            foreach ($results as $result) {
                $output .= '<li class="py"><a href="#">' . $result->name . '</a></li>';
            }
            $output .= '</ul>';
            return response()->json($output);
        }
    }

    /**
     *  quizQuestionSorted
     */
    public function quizQuestionSorted(Request $request): array
    {
        return $this->quizQuestion->quizQuestionSorted($request);
    }
}
