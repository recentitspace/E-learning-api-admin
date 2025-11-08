<?php

namespace Modules\LMS\Http\Controllers\Organization\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Repositories\Courses\TagRepository;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected TagRepository $tag) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        $tag = $this->tag->save($request);

        if (isset($request->modal_type)) {
            return response()->json([
                'status' => 'success',
                'modal_hide' => $request->modal_type
            ]);
        }
        if ($tag['status'] !== 'success') {
            return response()->json($tag);
        }
        return response()->json([
            'status' => 'success',
            'url' => route('tag.index')
        ]);
    }
}
