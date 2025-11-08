<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses\Quizzes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\AnswerRepository;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected AnswerRepository $answer) {}

    public function index(): JsonResponse
    {
        $answers = $this->answer->get();

        return response()->json($answers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $answer = $this->answer->save($request->all());

        return response()->json($answer);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        $answer = $this->answer->first($id);

        return response()->json($answer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        $answer = $this->answer->update($id, $request->all());

        return response()->json($answer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $answer = $this->answer->delete(id: $id);

        return response()->json($answer);
    }
}
