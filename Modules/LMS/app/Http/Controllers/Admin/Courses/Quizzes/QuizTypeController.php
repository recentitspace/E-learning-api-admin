<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses\Quizzes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuizTypeRepository;

class QuizTypeController extends Controller
{
    public function __construct(protected QuizTypeRepository $quizType) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $quizTypes = $this->quizType->get();
        return response()->json($quizTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        $quizType = $this->quizType->save($request->all());
        return response()->json($quizType);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        $quizType = $this->quizType->first($id);
        return response()->json($quizType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        $quizType = $this->quizType->update($id, $request->all());

        return response()->json($quizType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $quizType = $this->quizType->delete(id: $id);
        return response()->json($quizType);
    }
}
