<?php

namespace Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Roles\Repositories\RoleRepository;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Class RoleController
     */
    public function __construct(protected RoleRepository $role) {}

    /**
     * Display a listing of roles.
     */
    public function index()
    {
        // Retrieve paginated list of roles with permissions
        $roles = $this->role::paginate(10, relations: ['permissions'])['data'];
        return view('roles::roles.index', compact('roles'));
    }

    /**
     * Show form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::get()->groupBy('module');
        return view('roles::roles.form', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add roles
        if (!has_permissions($request->user(), ['add.role'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save role and capture the response
        $role = $this->role->save($request->all());

        // Return response based on save status
        return $role['status'] !== 'success'
            ? response()->json($role)
            :  $this->jsonSuccess('Role saved successfully.', route('role.index'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit roles
        if (!has_permissions($request->user(), ['edit.role'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $permissions = Permission::get()->groupBy('module');
        // Retrieve role data with permissions for editing
        $response = $this->role->first($id, relations: ['permissions']);
        $role = $response['data'] ?? [];
        $rolePermissions =  $role?->permissions?->pluck('id')->toArray() ?? [];
        return view('roles::roles.form', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        // Check if the user has permission to edit roles
        if (!has_permissions($request->user(), ['edit.role'])) {
            return json_error('You have no permission.');
        }
        // Attempt to update role and capture the response
        $role = $this->role->update($id, $request);

        return $role['status'] !== 'success'
            ? response()->json($role)
            :  $this->jsonSuccess('Role updated successfully.', route('role.index'));
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check if the user has permission to delete roles
        if (!has_permissions($request->user(), ['delete.role'])) {
            return json_error('You have no permission.');
        }

        // Attempt to delete role and return response
        $role = $this->role->delete(id: $id);
        return response()->json($role);
    }
}
