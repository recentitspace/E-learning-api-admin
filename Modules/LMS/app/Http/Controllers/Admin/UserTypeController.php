<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Repositories\UserTypeRepository;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected UserTypeRepository $userType) {}

    public function index(): JsonResponse
    {
        $userTypes = $this->userType->get();
        return response()->json($userTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        $userType = $this->userType->save($request->all());

        return response()->json($userType);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        $userType = $this->userType->first($id);

        return response()->json($userType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        $userType = $this->userType->update($id, $request->all());

        return response()->json($userType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $userType = $this->userType->delete(id: $id);

        return response()->json($userType);
    }
}
