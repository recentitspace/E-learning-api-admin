<?php

namespace Modules\LMS\Http\Controllers\Admin\Skill;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Skill\SkillRepository;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected SkillRepository $skill) {}

    public function index(): JsonResponse
    {
        //
        $skills = $this->skill::get();

        return response()->json($skills);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $skill = $this->skill->save($request->all());

        return response()->json($skill);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        //
        $skill = $this->skill->first($id);

        return response()->json($skill);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        //
        $skill = $this->skill->update($id, $request->all());

        return response()->json($skill);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        //
        $skill = $this->skill->delete(id: $id);

        return response()->json($skill);
    }
}
