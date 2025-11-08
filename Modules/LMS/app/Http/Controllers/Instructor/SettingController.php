<?php

namespace Modules\LMS\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Modules\LMS\Http\Requests\UserTypeRequest;
use Modules\LMS\Repositories\Auth\UserRepository;

class SettingController extends Controller
{
    public function __construct(protected UserRepository $user) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('portal::instructor.setting.profile-form');
    }

    /**
     *  profileUpdate
     */
    public function updateProfile(UserTypeRequest $request)
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
