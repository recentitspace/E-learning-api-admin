<?php

namespace Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Roles\Repositories\PermissionRepository;

class PermissionController extends Controller
{

    /**
     * Class PermissionController
     */
    public function __construct(protected PermissionRepository $permission) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve paginated list of permissions
        $permissions = $this->permission::paginate(20)['data'];
        return view('roles::permissions.index', compact('permissions'));
    }

    /**
     * Show form for creating a new permission.
     */
    public function create()
    {
        return view('roles::permissions.form');
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add permissions
        if (!has_permissions($request->user(), ['add.permission'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save permission and capture the response
        $permission = $this->permission->save($request);

        // Check if the permission was updated successfully
        return $permission['status'] !== 'success'
            ? response()->json($permission)
            : $this->jsonSuccess('Permission saved successfully.', route('permission.index'));
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit permissions
        if (!has_permissions($request->user(), ['edit.permission'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        // Retrieve permission for editing
        $response = $this->permission->first($id);
        $permission = $response['data'];

        return view('roles::permissions.form', compact('permission'));
    }

    /**
     * Show the specified permission.
     */
    public function show($id): JsonResponse
    {
        // Retrieve and return specified permission as JSON
        $permission = $this->permission->first($id);
        return response()->json($permission);
    }

    /**
     * Update the specified permission in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check if the user has permission to edit permissions
        if (!has_permissions($request->user(), ['edit.permission'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update permission and capture the response
        $permission = $this->permission->update($id, $request->all());

        // Check if the permission was updated successfully
        return $permission['status'] !== 'success'
            ? response()->json($permission)
            : $this->jsonSuccess('Permission updated successfully.', route('permission.index'));
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete permissions
        if (!has_permissions($request->user(), ['delete.permission'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete permission and return response
        $permission = $this->permission->delete(id: $id);
        return response()->json($permission);
    }
}
