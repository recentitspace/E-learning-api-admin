<?php

namespace Modules\LMS\Repositories\Instructor;

use Exception;
use Modules\LMS\Models\User;
use Modules\LMS\Models\Auth\Admin;
use Modules\LMS\Models\Designation;
use Illuminate\Support\Facades\Hash;
use Modules\LMS\Classes\EmailFormat;
use Modules\LMS\Models\Auth\Instructor;
use Modules\LMS\Classes\NotificationFormat;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Repositories\Courses\CourseRepository;

class InstructorRepository extends BaseRepository
{
    protected static $model = Instructor::class;

    protected static $modelOne = User::class;

    protected static $exactSearchFields = [];

    public function __construct(protected CourseRepository $course) {}

    protected static $rules = [
        'save' => [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'designation' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:instructors,phone',
            'password' => 'required|min:5|max:12|confirmed',
        ],
        'update' => [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ],
    ];

    protected static $excludedFields = [
        'save' => ['locale', 'password', 'password_confirmation', 'user_type', '_token', '_method', 'image', 'organization_id', 'email', 'designation', 'profile_cover'],
        'update' => ['locale', 'password', 'password_confirmation', '_token', '_method', 'image', 'organization_id', 'email', 'designation', 'profile_cover'],
    ];

    /**
     * @param  array  $data
     */
    public static function save($request): array
    {
        if ($request->hasFile('image')) {
            static::$rules['save']['image'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $image = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/instructors');
            $request->request->add([
                'profile_img' => $image,
            ]);
        }

        if ($request->hasFile('profile_cover')) {
            static::$rules['save']['profile_cover'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $coverPhoto = parent::upload($request, fieldname: 'profile_cover', file: '', folder: 'lms/instructors');
            $request->request->add([
                'cover_photo' => $coverPhoto,
            ]);
        }

        if (!empty($request->designation)) {
            $request->request->add(['designation_id' => self::designationSave($request->designation)]);
        }
        $instructor = parent::save($request->all());
        if ($instructor['status'] == 'success') {
            $user = $instructor['data']->user()->create(
                [
                    'guard' => 'instructor',
                    'email' => $request->email,
                    'password' => $request->password,
                    'organization_id' => $request->organization_id,
                    'username' => $request->first_name . ' ' . $request->last_name, // Set username from first_name and last_name
                ]
            );
            $user->assignRole('Instructor');
            $data = [
                'user_name' => $request->first_name,
                'email' => $request->email,
                'id' => $user->id,
                'role' => 'Instructor',
                'token' => Hash::make('first_name'),
                'app_name' => 'LMS Hub',
            ];
            $notificationData = [
                'user_name' => $instructor['data']->first_name . ' ' . $instructor['data']->last_name,
                'role' => 'Instructor',
                'created_at' => customDateFormate($user->created_at, $formate = 'M d Y H:i a'),
            ];
            EmailFormat::registrationMail($data);
            NotificationFormat::notificationToAdmin(Admin::all(), $notificationData);

            if ($user?->userable) {
                $userableData = self::translateData($request->all());
                self::translate($user?->userable, $userableData, locale: $request->locale ?? app()->getLocale());
            }
        }

        return $instructor;
    }

    /**
     * @param  int  $id
     * @param  mixed  $request
     */
    public static function update($id, $request): array
    {
        $user = static::$modelOne::with('userable')->where('id', $id)->first();

        if ($request->locale && $user?->userable) {
            $userableData = self::translateData($request->all());
            $defaultLanguage = app()->getLocale();
            self::translate(model: $user?->userable,  data: $userableData, locale: $request->locale);
            if ($request->designation && $user?->userable?->designation) {
                $designationData = [
                    'title' => $request->designation,
                ];
                self::translate(model: $user?->userable?->designation,  data: $designationData, locale: $request->locale);
            }

            if ($request->locale &&  $defaultLanguage !== $request->locale) {
                return [
                    'status' => 'success',
                    'data' => $user,
                ];
            }
        }

        static::$rules['update'] = [
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|unique:instructors,phone,' . $user?->userable?->id,
        ];

        if (!empty($request->password)) {
            static::$rules['update']['password'] = 'required|min:5|max:12|confirmed';
            $user->update([
                'password' => $request->password,
            ]);
        }
        if ($request->hasFile('image')) {
            static::$rules['update']['image'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $image = parent::upload($request, fieldname: 'image', file: $user?->userable?->profile_img, folder: 'lms/instructors');
            $request->request->add([
                'profile_img' => $image,
            ]);
        }

        if ($request->hasFile('profile_cover')) {
            static::$rules['update']['profile_cover'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $coverPhoto = parent::upload($request, fieldname: 'profile_cover', file: $user?->userable?->cover_photo, folder: 'lms/instructors');
            $request->request->add([
                'cover_photo' => $coverPhoto,
            ]);
        }

        if ($request->designation) {
            $request->request->add(['designation_id' => self::designationSave($request->designation)]);
        }

        return parent::update($user?->userable?->id, $request->all());
    }

    /**
     * statusChange
     *
     * @param  int  $id
     * @return array
     */
    public function statusChange($id)
    {
        $instructor = static::$model::firstWhere('id', $id);
        if ($instructor) {
            $instructor->status = !$instructor->status;
            $instructor->update();
            $data = [
                'status' => $instructor->status == 1 ? 'activated' : 'deactivated',
                'user_name' => $instructor->first_name . ' ' . $instructor->last_name,
                'email' => $instructor?->user?->email,
                'app_name' => config('app.name'),
            ];
            NotificationFormat::notifyAccountStatus($instructor->user, $data);
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
     *  designation
     *
     * @param  string  $name
     * @return int
     */
    public static function designationSave($name)
    {
        $designation = Designation::firstWhere('title', $name);
        if (!$designation) {
            $designation = new Designation;
            $designation->title = $name;
            $designation->save();
        }

        return $designation->id;
    }

    public static function translateData(array $data)
    {
        $data = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'] ?? '',
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
