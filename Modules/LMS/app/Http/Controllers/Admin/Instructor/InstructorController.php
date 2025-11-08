<?php

namespace Modules\LMS\Http\Controllers\Admin\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Instructor\InstructorRepository;

class InstructorController extends Controller
{
    public function __construct(protected UserRepository $user, protected InstructorRepository $instructor)
    {
        $this->user->setGuard('instructor');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $guard = 'instructor';
        $reports = $this->user->reportUsers();
        $response = $this->user->getUserBySearch($guard, $request);
        $instructors = $response ?? [];

        $countResponse = $this->user->trashCount(options: [
            'where' => ['guard' => 'instructor']
        ]);

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        return view('portal::admin.instructor.index', compact('instructors', 'reports', 'countData'));
    }

    /**
     * newly created from resource in storage.
     */
    public function create()
    {
        return view('portal::admin.instructor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add an instructor.
        if (!has_permissions($request->user(), ['add.instructor'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the instructor and capture the response.
        $instructor = $this->instructor->save($request);

        // Check if the instructor was saved successfully.
        if ($instructor['status'] != 'success') {
            return response()->json($instructor);
        }

        return $this->jsonSuccess('Instructor has been saved successfully.',  route('instructor.index'));
    }

    /**
     *  the specified resource in edit.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit the instructor.
        if (!has_permissions($request->user(), ['edit.instructor'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the instructor for editing.
        $response = $this->user->first($id, relations: ['userable.designation.translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        $instructor = $response['data'] ?? null;

        // Return the edit view with the instructor data.
        return view('portal::admin.instructor.edit', compact('instructor'));
    }

    /**
     *  the specified resource in edit.
     */
    public function profile($id)
    {
        // Display the instructor profile.
        $response = $this->user->first($id, withTrashed: true, relations: ['userable.designation', 'userable.country', 'userable.state', 'userable.city', 'educations']);
        $user =  $response['data'] ?? null;
        return view('portal::admin.instructor.profile', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user has permission to update the instructor.
        if (!has_permissions($request->user(), ['edit.instructor'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the instructor and capture the response.
        $instructor = $this->instructor->update($id, $request);

        // Check if the update was successful.
        if ($instructor['status'] !== 'success') {
            return response()->json($instructor);
        }

        return $this->jsonSuccess('Instructor has been updated successfully.', route('instructor.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Check if the user has permission to delete the instructor.
        if (!has_permissions($request->user(), ['delete.instructor'])) {
            return json_error('You have no permission.');
        }
        $response = $this->user->userDelete($id, ['is_verify' => 0]);

        $response['url'] = route('instructor.index');
        // Attempt to delete the instructor and return the response.
        return response()->json($response);
    }

    /**
     *  status change
     */
    public function statusChange($id, Request $request)
    {
        // Check if the user has permission to change the instructor status.
        if (!has_permissions($request->user(), ['status.instructor'])) {
            return json_error('You have no permission.');
        }

        // Attempt to change the status and capture the response.
        $instructor = $this->instructor->statusChange($id);

        // Return the response from the status change operation.
        return response()->json($instructor);
    }

    /**
     * user verify email.
     */
    public function verifyEmail($id, Request $request)
    {
        // Check if the user has permission to verify the instructor's email.
        if (!has_permissions($request->user(), ['verify.instructor'])) {
            return json_error('You have no permission.');
        }

        // Attempt to verify the email and capture the response.
        $user = $this->user->verifyMail($id);

        // Return the response from the email verification operation.
        return response()->json($user);
    }



    public function restore(int $id)
    {
        $response = $this->user->restore(id: $id);
        $response['url'] = route('instructor.index');
        return response()->json($response);
    }
}
