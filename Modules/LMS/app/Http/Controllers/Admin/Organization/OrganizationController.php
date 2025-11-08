<?php

namespace Modules\LMS\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Organization\OrganizationRepository;

class OrganizationController extends Controller
{
    public function __construct(protected UserRepository $user, protected OrganizationRepository $organization)
    {
        $this->user->setGuard('organization');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $reports = $this->user->reportUsers();

        $guard = 'organization';
        $response = $this->user->getUserBySearch($guard, $request);
        $organizations = $response ?? [];
        $countResponse = $this->user->trashCount(options: [
            'where' => ['guard' => 'organization']
        ]);

        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        return view('portal::admin.organization.index', compact('organizations', 'reports', 'countData'));
    }

    /**
     * newly created from resource in storage.
     */
    public function create()
    {
        return view('portal::admin.organization.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has permission to add an organization.
        if (!has_permissions($request->user(), ['add.organization'])) {
            return json_error('You have no permission.');
        }

        // Attempt to save the organization and capture the response.
        $organization = $this->organization->save($request);

        // Check if the organization was saved successfully.
        if ($organization['status'] !== 'success') {
            return response()->json($organization);
        }
        return  $this->jsonSuccess('Organization has been saved successfully', route('organization.index'));
    }

    /**
     *  the specified resource in edit.
     */
    public function edit($id, Request $request)
    {
        // Check if the user has permission to edit the organization.
        if (!has_permissions($request->user(), ['edit.organization'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }

        $locale = $request->locale ?? app()->getLocale();
        // Retrieve the organization for editing.
        $response = $this->user->first($id, withTrashed: true, relations: ['userable.translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);
        $organization = $response['data'] ?? null;

        // Return the edit view with the organization data.
        return view('portal::admin.organization.edit', compact('organization'));
    }

    /**
     *  Organization Profile
     */
    public function profile($id)
    {
        $response = $this->user->first($id, withTrashed: true,  relations: ['userable.country', 'userable.state', 'userable.city', 'educations']);
        $user = $response['data'] ?? null;
        return view('portal::admin.organization.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if the user has permission to update the organization.
        if (!has_permissions($request->user(), ['edit.organization'])) {
            return json_error('You have no permission.');
        }
        // Attempt to update the organization and capture the response.
        $organization = $this->organization->update($id, $request);

        // Check if the update was successful.
        if ($organization['status'] !== 'success') {
            return response()->json($organization);
        }
        return $this->jsonSuccess('Organization has been saved successfully', route('organization.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Check if the user has permission to delete the organization.
        if (!has_permissions($request->user(), ['delete.organization'])) {
            return json_error('You have no permission.');
        }

        $response = $this->user->userDelete($id, [
            'is_verify' => 0
        ]);
        $response['url'] = route('organization.index');
        // Attempt to delete the organization and return the response.
        return response()->json($response);
    }

    /**
     *  status change
     */
    public function statusChange($id, Request $request)
    {
        // Check if the user has permission to change the organization status.
        if (!has_permissions($request->user(), ['status.organization'])) {
            return json_error('You have no permission.');
        }

        // Attempt to change the status and capture the response.
        $organization = $this->organization->statusChange($id);

        // Return the response from the status change operation.
        return response()->json($organization);
    }

    /**
     * user verify email.
     */
    public function verifyEmail($id, Request $request)
    {
        // Check if the user has permission to verify the student's email.
        if (!has_permissions($request->user(), ['verify.student'])) {
            return json_error('You have no permission.');
        }

        // Attempt to verify the email and capture the response.
        $user = $this->user->verifyMail($id);

        // Return the response from the email verification operation.
        return response()->json($user);
    }

    /**
     *  getOrganizationName
     *
     * @param string $name
     *
     * @return JsonResponse
     */
    public function getOrganizationName($name): JsonResponse
    {
        $organization = $this->organization->getName($name);
        return response()->json($organization);
    }

    /**
     * getInstructor
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function getInstructor($id, Request $request): JsonResponse
    {


        $locale =  $request->locale ?? app()->getLocale();
        $users = $this->organization->getInstructorByOrganization($id, locale: $locale);
        $data = view('portal::admin.instructor.instruct-select', compact('users', 'locale'))->render();
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'locale' =>   $locale
        ]);
    }

    /**
     * Method restore
     *
     * @param int $id 
     *
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $response = $this->user->restore(id: $id);
        $response['url'] = route('organization.index');
        return response()->json($response);
    }
}
