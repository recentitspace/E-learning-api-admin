<?php

namespace Modules\Roles\Repositories\Staff;

use Modules\LMS\Models\Auth\Admin;
use Illuminate\Support\Facades\Session;
use Modules\LMS\Repositories\BaseRepository;

class StaffRepository extends BaseRepository
{
    protected static $model = Admin::class;
    protected static $exactSearchFields = [];
    protected static $rules = [
        'save' => [
            'name' => 'required',
            'email' => 'required|unique:admins,email',
            'phone' => 'required',
            'password' => 'required|min:5|max:12|confirmed',

        ],
        'update' => [
            'name' => 'required',
            'phone' => 'required',
        ],
    ];

    protected static $excludedFields = [
        'save' => ['password_confirmation', 'roles', '_token', 'image', 'permissions'],
        'update' => ['password_confirmation', 'roles', '_token', '_method', 'image',  'permissions'],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {

        if ($request->hasFile('image')) {
            static::$rules['save']['image'] = ['image' => 'required|image|mimes:jpg,png,jpeg,svg,webp'];
            $image = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/admins');
            $request->request->add([
                'profile_img' => $image,
            ]);
        }
        $admin = parent::save($request->all());
        if ($admin['status'] == 'success' && ! empty($request->roles)) {
            $admin['data']->assignRole($request->roles);
        }
        if ($admin['status'] == 'success' && ! empty($request->permissions)) {
            $admin['data']->syncPermissions($request->permissions);
        }

        return $admin;
    }

    /**
     * @param  int  $id
     * @param  mixed  $data
     */
    public static function update($id, $request): array
    {

        $response = parent::first($id);
        $staff = $response['data'];
        if ($request->hasFile('image')) {
            static::$rules['update']['image'] = 'required|image|mimes:jpg,png,jpeg,svg,webp';
            $image = parent::upload($request, fieldname: 'image', file: $staff->profile_img ?? null, folder: 'lms/admins');
            $request->request->add(['profile_img' => $image ? $image : $staff->profile_img]);
        }
        static::$rules['update']['email']  =  'required|unique:admins,email,' . $id;

        if (!empty($request->password)) {
            static::$rules['update']['password'] = 'required|min:5|max:12|confirmed';
            $request->merge(['password' => $request->password]);
        } else {
            static::$excludedFields['update']['password'] = true;
        }
        $response = parent::update($id, $request->all());

        if ($response['status'] == 'success' && ! empty($request->roles)) {
            $response['data']->syncRoles($request->roles);
        }
        if ($response['status'] == 'success' && ! empty($request->permissions)) {
            $response['data']->syncPermissions($request->permissions);
        }

        return $response;
    }
}
