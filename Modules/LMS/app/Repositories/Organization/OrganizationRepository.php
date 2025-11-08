<?php

namespace Modules\LMS\Repositories\Organization;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\LMS\Classes\EmailFormat;
use Modules\LMS\Classes\NotificationFormat;
use Modules\LMS\Models\Auth\Admin;
use Modules\LMS\Models\Auth\Organization;
use Modules\LMS\Models\User;
use Modules\LMS\Repositories\BaseRepository;

class OrganizationRepository extends BaseRepository
{
    protected static $model = Organization::class;
    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:organizations,phone',
            'password' => 'required|min:5|max:12|confirmed',
        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['password_confirmation', 'password', 'user_type', '_token', 'email', '_method', 'image', 'profile_cover', 'locale'],
        'update' => ['password_confirmation', 'password', 'user_type', '_token', 'email', '_method', 'image', 'profile_cover', 'locale'],
    ];

    /**
     * @param int $id
     * @param Request $request
     * @return {array}
     */
    public static function save($request): array
    {
        if ($request->hasFile('image')) {
            static::$rules['save']['image'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $image = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/organizations');
            $request->request->add([
                'profile_img' => $image,
            ]);
        }
        if ($request->hasFile('profile_cover')) {
            static::$rules['save']['profile_cover'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $coverPhoto = parent::upload($request, fieldname: 'profile_cover', file: '', folder: 'lms/organizations');
            $request->request->add([
                'cover_photo' => $coverPhoto,
            ]);
        }

        $organization = parent::save($request->all());
        if ($organization['status'] == 'success') {
            $user = $organization['data']->user()->create(
                [
                    'guard' => 'organization',
                    'email' => $request->email,
                    'password' => $request->password,
                    'username' => $request->name, // Set username from organization name
                ]
            );
            $user->assignRole('Organization');

            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                'id' => $user->id,
                'role' => 'Organization',
                'token' => Hash::make('name'),
                'app_name' => 'LMS Hub',
            ];

            $notificationData = [
                'user_name' => $organization['data']->name,
                'role' => 'Organization',
                'created_at' => customDateFormate($user->created_at, $formate = 'M d Y H:i a'),
            ];
            EmailFormat::registrationMail($data);
            NotificationFormat::notificationToAdmin(Admin::all(), $notificationData);

            if ($user?->userable) {
                $userableData = self::translateData($request->all());
                self::translate($user?->userable, $userableData, locale: $request->locale ?? app()->getLocale());
            }
        }

        return $organization;
    }

    /**
     * @param  int  $id
     * @param  mixed  $request
     * @return {array}
     */
    public static function update($id, $request): array
    {
        $user = User::with('userable')->where('id', $id)->first();

        if ($request->locale && method_exists($user, 'userable')) {
            $userable = $user->userable;
            $userableData = self::translateData($request->all());
            $defaultLanguage = app()->getLocale();
            self::translate(model: $userable,  data: $userableData, locale: $request->locale);

            if ($request->designation && method_exists($userable, 'designation')) {
                $designationData = [
                    'title' => $request->designation,
                ];
                self::translate(model: $userable->designation,  data: $designationData, locale: $request->locale);
            }

            if ($request->locale &&  $defaultLanguage !== $request->locale) {
                return [
                    'status' => 'success',
                    'data' => $user,
                ];
            }
        }

        if ($request->hasFile('image')) {
            static::$rules['update']['image'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $image = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/organizations');
            $request->request->add([
                'profile_img' => $image,
            ]);
        }

        if ($request->hasFile('profile_cover')) {
            static::$rules['update']['profile_cover'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $coverPhoto = parent::upload($request, fieldname: 'profile_cover', file: '', folder: 'lms/organizations');
            $request->request->add([
                'cover_photo' => $coverPhoto,
            ]);
        }

        static::$rules['update'] = [
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|unique:organizations,phone,' . $user?->userable?->id,
            'name' => 'required|unique:organizations,name,' . $user?->userable?->id,
        ];
        if (!empty($request->password)) {
            static::$rules['update']['password'] = 'required|min:5|max:12|confirmed';
            $user->update([
                'password' => $request->password,
            ]);
        }

        return parent::update($user?->userable?->id, $request->all());
    }

    /**
     *  delete
     *
     * @param  int  $id
     * @return {array}
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $instructor = User::firstWhere('id', $id);
        if ($instructor) {
            $instructor->userable()->delete();
            $instructor->delete();

            return ['status' => 'success'];
        }

        return ['status' => 'error'];
    }

    /**
     * getName
     *
     * @param  string  $name
     */
    public function getName($name): array
    {
        try {
            $organization = static::$model::with('organizations')->where('name', 'like', '%' . $name . '%')->select('id', 'name')->get();

            return [
                'status' => 'success',
                'data' => $organization,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'data' => $th->getMessage(),
            ];
        }
    }

    /**
     * statusChange
     *
     * @param  int  $id
     * @return {array}
     */
    public function statusChange($id)
    {
        $organization = static::$model::firstWhere('id', $id);
        if ($organization) {
            $organization->status = ! $organization->status;
            $organization->update();

            $data = [
                'status' => $organization->status == 1 ? 'activated' : 'deactivated',
                'user_name' => $organization->name,
                'email' => $organization?->user?->email,
                'app_name' => config('app.name'),
            ];

            NotificationFormat::notifyAccountStatus($organization->user, $data);
            EmailFormat::accountStatusChange($data);

            return [
                'status' => 'success',
                'message' => translate('Status Change Successfully'),
            ];
        }

        return [
            'status' => 'error',
            'message' => translate('something Wrong!'),
        ];
    }

    /**
     * getInstructorByOrganization
     *
     * @param  $id  $id
     * @return object
     */
    public function getInstructorByOrganization($id, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $query = User::with([
            'userable',
            'userable.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);

        if ($id != 'no-select') {
            $query->where('organization_id', $id);
        } else {
            $query->where('guard', 'instructor');
        }

        return $query->get();
    }

    public static function translateData(array $data)
    {
        $data = [
            'name' => $data['name'],
            'address' => $data['address'],
            'about' => $data['about'] ?? '',
        ];

        return $data;
    }

    public static function translate($model, $data, $locale)
    {
        $model->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
