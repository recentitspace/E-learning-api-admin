<?php

namespace Modules\Roles\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Modules\Roles\Repositories\Staff\StaffRepository;

class AdminController extends Controller
{
    /**
     * Class StaffController
     */
    public function __construct(protected StaffRepository $staff) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Retrieve paginated list of staff with roles
        $response = $this->staff->paginate(item: 10);
        $staffs = $response['data'] ?? [];
        return view('roles::staff.index', compact('staffs'));
    }

    /**
     * Show form for creating a new staff member.
     */
    public function create(): View
    {
        $permissions = Permission::get()->groupBy('module');
        return view('roles::staff.form', compact('permissions'));
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if the user has permission to add staff
        if (!has_permissions($request->user(), ['add.staff'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save staff and capture the response
        $staff = $this->staff->save($request);

        // Check if the staff was saved successfully
        return $staff['status'] !== 'success'
            ? response()->json($staff)
            : $this->jsonSuccess('Admin saved successfully.', route('staff.index'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit staff
        if (!has_permissions($request->user(), ['edit.staff'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $permissions = Permission::get()->groupBy('module');


        // Retrieve staff with roles and permissions for editing
        $response = $this->staff->first($id, relations: ['permissions']);
        $staff = $response['data'] ?? [];

        $userPermissions =  $staff?->permissions?->pluck('id')->toArray() ?? [];

        return view('roles::staff.form', compact('staff', 'permissions', 'userPermissions'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request): JsonResponse
    {
        // Check if the user has permission to update staff
        if (!has_permissions($request->user(), ['update.staff'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update staff and capture the response
        $staff = $this->staff->update($request->id, $request);

        // Check if the staff was updated successfully
        return $staff['status'] !== 'success'
            ? response()->json($staff)
            : $this->jsonSuccess('Admin Update successfully.', route('staff.index'));
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        // Check if user exists in database
        $admin = \Modules\LMS\Models\Auth\Admin::where('email', $request->email)->first();
        
        if (!$admin || !Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => translate('Credential Wrong')
                ], 401);
            }
            toastr()->error(translate('Credential Wrong'));
            return redirect()->back();
        }

        $authenticatedAdmin = Auth::guard('admin')->user();
        
        // Create a Sanctum token that expires in 1 hour (60 minutes)
        $token = $authenticatedAdmin->createToken('auth_token', ['*'], now()->addHours(1))->plainTextToken;
        
        // Regenerate session ID for security
        $request->session()->regenerate();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => translate('Login successfully'),
                'token' => $token,
                'user' => [
                    'id' => $authenticatedAdmin->id,
                    'email' => $authenticatedAdmin->email,
                    'guard' => 'admin',
                ],
                'url' => route('admin.dashboard')
            ]);
        }

        toastr()->success(translate('Login successfully!'));
        return redirect()->route('admin.dashboard');
    }

    public function notFound()
    {
        return view('theme::404');
    }
}
