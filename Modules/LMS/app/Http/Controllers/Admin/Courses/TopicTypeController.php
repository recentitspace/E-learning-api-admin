<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Repositories\Courses\TopicTypeRepository;

class TopicTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected TopicTypeRepository $topicType) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Add slug to the request
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        $topicType = $this->topicType->save($request->all());
        return response()->json($topicType);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        //
        $topicType = $this->topicType->first($id);
        return response()->json($topicType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        // Add slug to the request
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        // Update the topic type
        $topicType = $this->topicType->update($id, $request->all());
        return response()->json($topicType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        // Delete the topic type
        $topicType = $this->topicType->delete(id: $id);
        return response()->json($topicType);
    }
}
