<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses\Quizzes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuestionRepository;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected QuestionRepository $question) {}

    public function index(): JsonResponse
    {

        $questions = $this->question::get();
        return response()->json($questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $question = $this->question->save($request->all());
        return response()->json($question);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {

        $question = $this->question->first($id);
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        $question = $this->question->update($id, $request->all());
        return response()->json($question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {

        $question = $this->question->delete(id: $id);
        return response()->json($question);
    }
}
