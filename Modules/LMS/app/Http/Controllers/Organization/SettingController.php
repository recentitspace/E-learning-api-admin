<?php

namespace Modules\LMS\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Modules\LMS\Http\Requests\UserTypeRequest;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Organization\OrganizationRepository;

class SettingController extends Controller
{
    public function __construct(protected OrganizationRepository $organization, protected UserRepository $user) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('portal::organization.setting.profile-form');
    }

    /**
     *  Update profile
     *
     * @param  mixed  $request
     * @return array
     */
    public function profileUpdate(UserTypeRequest $request)
    {

        return $this->user->updateProfile($request);
    }

    /**
     *  removeSkill
     *
     * @param  int  $id
     */
    public function removeSkill($id): array
    {
        return $this->user->removeSkill($id);
    }


    public function settingInformationUser($type, $id)
    {
        return $this->user->userExtraInformationDelete($type, $id);
    }
}
