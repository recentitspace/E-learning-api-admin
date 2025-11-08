<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\ChapterRepository;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected ChapterRepository $chapter) {}

    public function index(): JsonResponse
    {
        //
        $chapters = $this->chapter::get();
        return response()->json($chapters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $chapter = $this->chapter->save($request);
        if ($chapter['status'] != 'success') {
            return response()->json($chapter);
        }
        toastr()->success(translate('Chapter has been saved successfully!'));
        return response()->json([
            'status' => $chapter['status'],
            'type' => 'course'
        ]);
    }

    /**
     * edit the specified resource.
     */
    public function edit($id): JsonResponse
    {
        //
        $chapter = $this->chapter->first($id);

        return response()->json($chapter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        //
        $chapter = $this->chapter->update($id, $request->all());

        return response()->json($chapter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        //
        $chapter = $this->chapter->delete(id: $id);

        return response()->json($chapter);
    }

    /**
     *  chapterSorted
     *
     * @param  int  $request
     */
    public function chapterSorted(Request $request)
    {
        $chapter = $this->chapter->chapterSorted($request);

        return response()->json($chapter);
    }
}
