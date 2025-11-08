<?php

namespace Modules\LMS\Http\Controllers\Admin\Student;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Student\StudentRepository;

class StudentController extends Controller
{
    public function __construct(protected UserRepository $user, protected StudentRepository $student)
    {
        $this->user->setGuard('student');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reports = $this->user->reportUsers();
        $guard = 'student';
        $response = $this->user->getUserBySearch($guard, $request);
        $students = $response ?? [];

        $countResponse = $this->user->trashCount(options: [
            'where' => ['guard' => 'student']
        ]);

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }
        return view('portal::admin.student.index', compact('students', 'reports', 'countData'));
    }


    

    /**
     * newly created from resource in storage.
     */
    public function create()
    {
        return view('portal::admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add a student.
        if (!has_permissions($request->user(), ['add.student'])) {
            return json_error('You have no permission.');
        }
        // Attempt to save the student and capture the response.
        $response = $this->student->save($request);

        // Check if the save was successful.
        if ($response['status'] !== 'success') {
            // Return the response if the save was not successful.
            return response()->json($response);
        }
        return $this->jsonSuccess(
            'Student has been saved successfully.',
            route('student.index')
        );
    }

    /**
     *  the specified resource in edit.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit a student.
        if (!has_permissions($request->user(), ['edit.student'])) {
            // Show an error message if the user lacks permission.
            toastr()->error('You have no permission.');

            // Redirect back if permission is denied.
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the student record for editing.
        $response = $this->user->first($id, relations: ['userable.translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);
        $student = $response['data'] ?? null;

        if (!$student) {
            return view('portal::admin.404');
        }
        // Return the edit view with the student data.
        return view('portal::admin.student.edit', compact('student'));
    }

    /**
     *  View Student Profile.
     */
    public function profile($id)
    {
        // Retrieve the user by ID to display the profile.
        $response = $this->user->first($id, withTrashed: true, relations: ['userable.country', 'userable.state', 'userable.city']);
        $user =  $response['data'] ?? null;
        if (!$user) {
            return view('portal::admin.404');
        }

        // Return the profile view with the user data.
        return view('portal::admin.student.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user has permission to add a student.
        if (!has_permissions($request->user(), ['edit.student'])) {
            return json_error('You have no permission.');
        }
        // Attempt to save the student and capture the response.
        $response = $this->student->update($id, $request);

        // Check if the save was successful.
        if ($response['status'] !== 'success') {
            // Return the response if the save was not successful.
            return response()->json($response);
        }
        return $this->jsonSuccess(
            'Student has been update successfully.',
            route('student.index')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Check if the user has permission to delete a student.
        if (!has_permissions($request->user(), ['delete.student'])) {
            return json_error('You have no permission.');
        }
        // Attempt to delete the student and capture the response.
        $response = $this->user->userDelete($id, data: [
            'is_verify' => 0
        ]);
        $response['url'] = route('student.index', ['filter' => $request->filter ?? '']);
        // Return the response from the delete operation.
        return response()->json($response);
    }

    /**
     *  status change
     */
    public function statusChange($id, Request $request)
    {
        // Check if the user has permission to change the student's status.
        if (!has_permissions($request->user(), ['status.student'])) {
            return json_error('You have no permission.');
        }
        // Attempt to change the status and capture the response.
        $student = $this->student->statusChange($id);

        // Return the response from the status change operation.
        return response()->json($student);
    }

    /**
     * Verify the email of the specified user.
     *
     * @param int $id The ID of the student whose email will be verified.
     * @param Request $request The request object.
     * @return JsonResponse A JSON response indicating success or failure.
     */
    public function verifyEmail($id, Request $request)
    {
        // Check if the user has permission to verify a student's email.
        if (!has_permissions($request->user(), ['verify.student'])) {
            return json_error('You have no permission.');
        }
        // Attempt to verify the email and capture the response.
        $user = $this->user->verifyMail($id);

        // Return the response from the email verification operation.
        return response()->json($user);
    }


    public function restore(Request $request, int $id)
    {
        $response = $this->user->restore(id: $id);
        $response['url'] = route('student.index', ['filter' => $request->filter ?? '']);
        return response()->json($response);
    }
}
