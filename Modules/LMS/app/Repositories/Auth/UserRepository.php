<?php

namespace Modules\LMS\Repositories\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\LMS\Models\User;
use Illuminate\Support\Carbon;
use Modules\LMS\Enums\CourseStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\LMS\Classes\EmailFormat;
use Modules\LMS\Models\Auth\Student;
use Illuminate\Support\Facades\Storage;
use Modules\LMS\Models\Auth\Instructor;
use Modules\LMS\Enums\UserAccountStatus;
use Illuminate\Support\Facades\Validator;
use Modules\LMS\Models\Auth\Organization;
use Modules\LMS\Models\Auth\PasswordReset;
use Modules\LMS\Models\Auth\UserEducation;
use Modules\LMS\Models\Auth\UserExperience;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Models\Wishlist;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Repositories\Skill\SkillRepository;
use Modules\LMS\Repositories\User\CompanyRepository;
use Modules\LMS\Repositories\User\UniversityRepository;

class UserRepository  extends BaseRepository
{
    protected static $model = User::class;

    protected static $purchaseDetails = PurchaseDetails::class;

    protected $guard;

    public function __construct(
        protected UniversityRepository $university,
        protected CompanyRepository $company,
        protected SkillRepository $skill
    ) {}

    /**
     * upload
     *
     * @param  mixed  $request
     * @param  string  $fieldname
     * @param  string  $file
     * @param  string  $folder
     */
    public static function upload($request, $fieldname, $file, $folder)
    {
        if ($request->hasFile($fieldname)) {
            $source = $request->file($fieldname);
            $image_name = 'lms' . '-' . Str::random(8) . '.' . str_replace(' ', '-', $source->getClientOriginalExtension());
            if ($file != '') {
                if (Storage::disk('LMS')->exists('public/' . $folder . '/' . $file)) {
                    Storage::disk('LMS')->delete('public/' . $folder . '/' . $file);
                }
            }
            $source->storeAs('public/' . $folder, $image_name, 'LMS');

            return $image_name;
        }
    }

    /**
     * Method getUserBySearch
     *
     * @param  string  $guard
     * @param  Request  $request
     */
    public function getUserBySearch($guard, $request, $options = [])
    {

        $options = [];
        $filterType = '';
        if ($request->has('filter')) {
            $filterType = $request->filter ?? '';
        }
        switch ($filterType) {
            case 'trash':
                $options['onlyTrashed'] = [];
                break;
            case 'all':
                $options['withTrashed'] = [];
                break;
        }
        $users = static::$model::query();

        if (!is_array($options)) {
            $options = array($options);
        }
        // Set options.
        foreach ($options as $option => $value) {
            if (is_array($value)) {
                $users->{$option}(...$value);
            } else {
                $users->{$option}($value);
            }
        }


        $optionsList = ['guard' => $guard];
        if (! empty($request->verify) && $request->verify != 'all') {
            $verify = $request->verify == 'verified' ? 1 : 0;
            $users->where('is_verify', $verify);
        }
        if (! empty($request->status) && $request->status != 'all') {
            $status = $request->status == 'active' ? 1 : 0;
            $users->withWhereHas(
                'userable',
                function ($query) use ($status) {
                    $query->where('status', $status);
                }
            );
        }
        if (! empty($request->name_search)) {
            if ($guard == 'organization') {
                $users->whereHasMorph(
                    'userable',
                    [Organization::class],
                    function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->name_search . '%');
                    }
                );
                $users->with('organizationInstructors', 'organizationCourses');
            } else {
                $users->whereHasMorph(
                    'userable',
                    [Student::class, Instructor::class],
                    function ($query) use ($request) {
                        $query->whereAny(['first_name', 'last_name'], 'LIKE', '%' . $request->name_search . '%');
                    }
                );
                $users->with('userable.designation', 'courses', 'enrollments');
            }
        }

        if ($guard == 'organization') {
            $users->with('userable', 'organizationInstructors', 'organizationCourses');
        }
        if ($guard == 'instructor') {
            $users->with(['courses', 'userable.designation.translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }]);
        }

        if ($guard == 'student') {
            $users->with('userable', 'enrollments');
        }

        $users->with(['userable.translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }]);

        return $users->where($optionsList)
            ->latest()
            ->paginate(10);
    }

    /**
     * getUserByGuard
     *
     * @param  string  $guard
     * @param  int  $items
     */
    public function getUserByGuard($guard, $items = 10, $withTrashed = true)
    {
        $users = static::$model::query();
        $users->where('guard', $guard);
        if ($withTrashed) {
            $users->withTrashed();
        }
        return $items ? $users->paginate($items) : $users->get();
    }

    /**
     * first
     *
     * @param  $id  int
     * @return object
     */
    public function userFirst($id, $withTrashed = false, $locale = null)
    {
        $user = static::$model::query();

        if ($withTrashed) {
            $user->withTrashed();
        }
        $option['id'] = $id;
        if (isOrganization()) {
            $option['organization_id'] = authCheck()->id;
        }
        if (isInstructor()) {
            $user->with('courses');
            $user->with(['educations', 'experiences',  'userable.designation', 'userable.designation.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }]);
        }
        return $user->with(['userable.country', 'userable.state', 'userable.translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])
            ->where($option)
            ->firstOrFail();
    }

    /**
     * studentProfileView
     *
     * @param  $id  int
     * @return object
     */
    public function studentProfileView($id)
    {
        $user = static::$model::query();
        $option['id'] = $id;

        return $user->with('userable')
            ->where($option)
            ->firstOrFail();
    }

    /**
     * verifyMail
     *
     * @param  $id  int
     * @return {array}
     */
    public function verifyMail($id): array
    {
        $user = $this->userFirst($id);
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'something Wrong!',
            ];
        }

        $user->is_verify = ! $user->is_verify;
        $user->update();
        return [
            'status' => 'success',
            'message' => 'Email Verify Successfully',
        ];
    }

    /**
     * enrollmentCourse
     *
     * @return object
     */
    public function enrollmentCourse()
    {
        $user = static::$model::with(
            ['courses' => function ($query) {
                $query->whereHas('enrollments');
            }]
        )->firstWhere('id', authCheck()->id);

        return $user->courses;
    }

    /**
     * enrollmentOrganizationCourse
     *
     * @return object
     */
    public function enrollmentOrganizationCourse()
    {
        $user = static::$model::with(
            ['organizationCourses' => function ($query) {
                $query->whereHas('enrollments');
            }]
        )->firstWhere('id', authCheck()->id);

        return $user->organizationCourses;
    }

    /**
     * getUserById
     *
     * 
     */
    public function getUserById($id)
    {
        $user = static::$model::select('id', 'guard', 'email', 'userable_type', 'userable_id')
            ->where(['id' => $id, 'is_verify' => 1])
            ->firstOrFail();

        // Define the common relationships with conditions
        $relationships = [
            'educations',
            'experiences',
            'skills',
            'userable' => function ($query) {
                $query->where('status', UserAccountStatus::ACTIVATED);
            },
        ];

        // Check the user's guard type and add specific relationship
        if ($user->guard == 'instructor') {
            $user->load(array_merge($relationships, [
                'courses' => function ($query) {
                    $query->where('status', CourseStatus::APPROVED);
                }
            ]));
        } else {
            $user->load(array_merge($relationships, [
                'organizationCourses' => function ($query) {
                    $query->where('status', CourseStatus::APPROVED);
                }
            ]));
        }

        return $user;
    }

    /**
     * instructorList
     *
     * @param  mixed  $request
     */
    public function instructorList($request, $item = 6)
    {
        $options = [
            'is_verify' => 1,
            'guard' => $request->guard,
        ];
        $relations = [
            'socials',
        ];
        $users = static::$model::query();

        // Function to apply filters based on guard type
        // Guard mappings to simplify selection of filters and models
        $guardMappings = [
            'organization' => [
                'model' => Organization::class,
                'nameFields' => ['name'],
            ],
            'instructor' => [
                'model' => Instructor::class,
                'nameFields' => ['first_name', 'last_name'],
            ],
        ];

        // Apply the appropriate filters based on the guard
        if (isset($guardMappings[$request->guard])) {
            $guardConfig = $guardMappings[$request->guard];
            $users->whereHasMorph('userable', [$guardConfig['model']], function ($query) use ($request, $guardConfig) {
                $this->applyUserableFilters($query, $request, $guardConfig['nameFields']);
            });
        }

        if ($request->guard === 'organization') {
            $users->with(['organizations', 'userable.city', 'userable.country', 'userable.translations']);
        }
        if ($request->guard === 'instructor') {
            $users->with(['userable.designation', 'userable.translations']);
        }

        // Apply additional 'status' condition on 'userable' relationship
        $users->with('userable', function ($query) {
            $query->where('status', 1);
        });

        // Final query with pagination
        $users->where($options);
        $take = $request->take ?? 0;
        return $take ? $users->with($relations)->take($take)->get() : ($item ? $users->with($relations)->paginate($item) : $users->get());
    }

    function applyUserableFilters($query, $request, $nameFields)
    {
        if (!empty($request->title)) {
            $query->whereAny($nameFields, 'like', '%' . $request->title . '%');
        }
        if (!empty($request->languages)) {
            $query->whereIn('language_id', explode(',', $request->languages));
        }
        if (!empty($request->designations)) {
            $query->whereIn('designation_id', explode(',', $request->designations));
        }
        if (!empty($request->timeZones)) {
            $query->whereIn('time_zone_id', explode(',', $request->timeZones));
        }

        if (!empty($request->org_instructors)) {
            $query->whereIn('organization_id', explode(',', $request->org_instructors));
        }
    }
    /**
     * reportUsers
     */
    public function reportUsers(): array
    {

        $data['total_users'] = $this->getUserByGuard(guard: $this->guard,  items: '')->count();
        $data['total_verified'] = $this->verifiedUser()->count();
        $data['total_unverified'] = $this->unverifiedUser()->count();
        $data['total_active'] = $this->getUserStatus(status: 1)->count();
        $data['total_inactive'] = $this->getUserStatus(status: 0)->count();

        return $data;
    }

    /**
     * setGuard
     *
     * @param  string  $guard
     */
    public function setGuard($guard)
    {
        $this->guard = $guard;
    }

    /**
     * verifiedUser
     */
    public function verifiedUser()
    {
        $options['is_verify'] = 1;

        return $this->getUserByStatus($options);
    }

    /**
     * unverifiedUser
     */
    public function unverifiedUser()
    {
        $options['is_verify'] = 0;

        return $this->getUserByStatus($options);
    }

    /**
     * getUserStatus
     *
     * @param  int  $status
     */
    public function getUserStatus($status)
    {
        return static::$model::whereHasMorph(
            'userable',
            [
                Organization::class,
                Student::class,
                Instructor::class,
            ],
            function ($query) use ($status) {
                $query->where('status', $status);
            }
        )
            ->where('guard', $this->guard)->get();
    }

    /**
     * getUserByStatus
     *
     * @param  array  $options
     */
    public function getUserByStatus($options)
    {
        return static::$model::where($options)->where('guard', $this->guard)->get();
    }

    /**
     *  organizationInstructors
     *
     * @param  int  $item
     */
    public function organizationInstructors($item = 10, $options = [])
    {

        if (!is_array($options)) {
            $options = array($options);
        }

        $options = array_merge([
            'orderBy' => ['updated_at', 'DESC'],
        ], $options);

        $model = static::$model::query();

        // Set options.
        foreach ($options as $option => $value) {
            if (is_array($value)) {
                $model->{$option}(...$value);
            } else {
                $model->{$option}($value);
            }
        }

        return $model->with('userable', 'courses')->where('organization_id', authCheck()->id)->paginate($item);
    }

    public function organizationInstructorsCount($options = [], $relations = [], $withTrashed = false)
    {

        try {
            if (!is_array($options)) {
                $options = array($options);
            }
            $options = array_merge([
                'orderBy' => ['updated_at', 'DESC'],
            ], $options);

            $query = static::$model::query();
            foreach ($options as $option => $value) {
                if (is_array($value)) {
                    $query->{$option}(...$value);
                } else {
                    $query->{$option}($value);
                }
            }
            if ($withTrashed) {
                $query->withTrashed();
            }
            $models = $query->with($relations)->where('organization_id', authCheck()->id)->count();

            return [
                'status' => 'success',
                'data' => $models,
            ];
        } catch (\Exception $ex) {
            //throw $th;
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * dashboardInfoInstructor
     */
    public function dashboardInfoInstructor()
    {
        $user = User::where('id', authCheck()->id)
            ->withWhereHas(
                'courses',
                function ($query) {
                    $query->saleCountNumber()->orderBy('sale_count_number', 'DESC')->with('coursePrice', 'instructors', 'levels');
                    $query->where('organization_id', '=', null);
                }
            )
            ->first();


        $coursesId = $user?->courses?->pluck('id')->toArray() ?? [];

        $data['total_amount'] =  PurchaseDetails::whereIn('course_id', $coursesId)->sum('price');
        $data['total_platform_fee'] =  PurchaseDetails::whereIn('course_id', $coursesId)->sum('platform_fee');
        $data['total_course'] = authCheck()?->courses?->count() ?? 0;
        $data['total_bundle'] = $user?->userBundles?->count() ?? 0;

        return $data;
    }

    /**
     * dashboardInfoOrganization
     */
    public function dashboardInfoOrganization(): array
    {
        $user = User::where('id', authCheck()->id)
            ->withWhereHas(
                'organizationCourses',
                function ($query) {
                    $query->saleCountNumber()->orderBy('sale_count_number', 'DESC')
                        ->with('coursePrice', 'instructors.userable', 'levels');
                }
            )
            ->with('userBundles')
            ->first();

        $coursesId = $user?->organizationCourses?->pluck('id')->toArray() ?? [];
        $data['total_amount'] =   PurchaseDetails::whereIn('course_id', $coursesId)->sum('price');
        $data['total_course'] = $user?->organizationCourses?->count() ?? 0;
        $data['total_platform_fee'] =  PurchaseDetails::whereIn('course_id', $coursesId)->sum('platform_fee');
        $data['total_bundle'] = $user?->userBundles?->count() ?? 0;

        return $data;
    }

    /**
     * enrolledStudents
     */
    public function enrolledStudents()
    {
        $user = authCheck();
        if (isInstructor()) {
            $courses = $user->courses;
            $bundles =  $user->userBundles;
        }
        if (isOrganization()) {

            $courses = $user->organizationCourses ?? [];
        }
        $coursesId = !empty($courses) ? $courses->pluck('id') : [];
        $bundlesId = !empty($bundles) ?  $bundles->pluck('id') : [];
        $enrollments = PurchaseDetails::select('user_id')
            ->distinct()
            ->whereIn(
                'course_id',
                $coursesId
            )
            ->orWhereIn('bundle_id', $bundlesId)

            ->pluck('user_id');

        return User::with('enrollments', 'userable')
            ->whereIn('id', $enrollments)
            ->paginate(10);
    }

    /**
     *  profileUpdate
     *
     * @param  mixed  $request
     * @return {array}
     */
    public function updateProfile($request): array
    {
        try {
            $response = match ($request->form_key) {
                'basic' => $this->handleBasicForm($request),
                'media' => $this->handleMediaForm($request),
                'education' => $this->handleEducationForm($request),
                'company' => $this->handleCompanyForm($request),
                'skill' => $this->handleSkillForm($request),
                'extra-information' => $this->handleExtraInformationForm($request),
                default => $this->handleDefault(),
            };

            return $response;
        } catch (\Throwable $th) {
            return $this->handleError($th);
        }
    }

    /**
     * Handle the basic profile form submission.
     *
     * @param Request $request The incoming request object.
     * @return array Response indicating success with the form_key and ID.
     */
    private function handleBasicForm($request)
    {
        // Determine the appropriate profile update method based on the user's role
        $id = match (true) {
            isOrganization() => $this->organizationProfile($request), // Update organization profile.
            isInstructor() => $this->instructorProfile($request), // Update instructor profile.
            default => null, // Default case if no role matches.
        };

        return $this->createSuccessResponse($request->form_key, $id); // Return success response
    }

    /**
     * Handle the media upload form submission.
     *
     * @param Request $request The incoming request object.
     * @return array Response indicating success with the form_key and user ID.
     */
    private function handleMediaForm($request)
    {
        $userId = $this->mediaUpload($request); // Perform media upload

        return $this->createSuccessResponse($request->form_key, $userId); // Return success response
    }

    /**
     * Handle the education information form submission.
     *
     * @param Request $request The incoming request object.
     * @return array Response indicating success with the form_key and ID.
     */
    private function handleEducationForm($request)
    {
        $this->educations($request); // Update education information

        return $this->createSuccessResponse($request->form_key, $request->id); // Return success response
    }

    /**
     * Handle the company experience form submission.
     *
     * @param Request $request The incoming request object.
     * @return array Response indicating success with the form_key and ID.
     */
    private function handleCompanyForm($request)
    {
        $this->experience($request); // Update company experience information

        return $this->createSuccessResponse($request->form_key, $request->id); // Return success response
    }

    /**
     * Handle the skills form submission.
     *
     * @param Request $request The incoming request object.
     * @return array Response indicating success with the form_key and ID.
     */
    private function handleSkillForm($request)
    {
        $this->skill($request); // Update skills information
        return $this->createSuccessResponse($request->form_key, $request->id); // Return success response
    }

    /**
     * Handle the extra information form submission.
     *
     * @param Request $request The incoming request object.
     * @return array Response indicating success with the form_key and ID.
     */
    private function handleExtraInformationForm($request)
    {
        $this->extraInformation($request); // Update extra information

        return $this->createSuccessResponse($request->form_key, $request->id); // Return success response
    }

    /**
     * Handle the default case for unrecognized form_key values.
     *
     * @return array Error response indicating something went wrong.
     */
    private function handleDefault()
    {
        return [
            'status' => 'error',
            'message' => 'Something went wrong.', // Standard error message
        ];
    }

    /**
     * Handle errors that occur during processing.
     *
     * @param \Throwable $th The thrown exception.
     * @return array Error response with the exception message.
     */
    private function handleError(\Throwable $th)
    {
        return [
            'status' => 'error',
            'message' => 'An error occurred: ' . $th->getMessage(), // Include exception message
        ];
    }

    /**
     * Create a standardized success response.
     *
     * @param string $formKey The key indicating the form type.
     * @param mixed $id The ID associated with the form submission.
     * @return array Success response indicating the operation's success.
     */
    private function createSuccessResponse(string $formKey, $id)
    {
        return [
            'status' => 'success', // Indicate success status
            'form_key' => $formKey, // Include form key in response
            'id' => $id, // Include relevant ID in response
            'message' => 'Update successfully.', // Standard success message
        ];
    }


    /**
     * organizationProfile
     *
     * @param  mixed  $request
     * @return int
     */
    public function organizationProfile($request)
    {
        $organization = Organization::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'about' => $request->about,
                'language_id' => $request->language_id,
                'time_zone_id' => $request->time_zone_id,
            ]
        );
        if (!empty($request->password)) {
            $organization->user()->update([
                'password' => Hash::make($request->password),
            ]);
        }
        return $organization->id;
    }

    /**
     * instructorProfile
     *
     * @param  mixed  $request
     * @return int
     */
    public function instructorProfile($request)
    {
        $instructor = Instructor::updateOrCreate(
            ['id' => $request->id],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'about' => $request->about,
                'language_id' => $request->language_id,
                'time_zone_id' => $request->time_zone_id,
            ]
        );
        if (!empty($request->password)) {
            $instructor->user()->update([
                'password' => Hash::make($request->password),
            ]);
        }
        return $instructor->id;
    }

    /**
     * educations
     *
     * @param  mixed  $request
     * @return void
     */
    public function educations($request)
    {
        if (isset($request->educations) && is_array($request->educations)) {
            UserEducation::where('user_id', $request->user_id)->delete();
            foreach ($request->educations as $education) {
                if (isset($education['name'])) {
                    UserEducation::create(
                        [
                            'user_id' => $request->user_id,
                            'university_id' => $this->university->universitySave($education['name']),
                            'department' => $education['department'] ?? null,
                            'degree' => $education['degree'] ?? null,
                            'cgpa' => $education['cgpa'] ?? null,
                            'duration' => $education['duration'] ?? null,
                            'passing_year' => $education['passing_year'] ?? null,
                        ]
                    );
                }
            }
        }
    }

    /**
     * mediaUpload
     *
     * @param  mixed  $request
     * @return int
     */
    public function mediaUpload($request)
    {
        if (isOrganization()) {
            $user = Organization::firstWhere('id', $request->id);
            $folder = 'lms/organizations';
        }

        if (isInstructor()) {
            $user = Instructor::firstWhere('id', $request->id);
            $folder = 'lms/instructors';
        }

        $profileImg = '';
        $coverImg = '';
        if ($request->hasFile('profile_image')) {
            $profileImg = $this->upload($request, fieldname: 'profile_image', file: $organization->profile_img ?? null, folder: $folder);
        }
        if ($request->hasFile('profile_cover')) {
            $coverImg = $this->upload($request, fieldname: 'profile_cover', file: $organization->cover_photo ?? null, folder: $folder);
        }
        $user->profile_img = $profileImg ? $profileImg : $user->profile_img;
        $user->cover_photo = $coverImg ? $coverImg : $user->cover_photo;
        $user->save();

        return $user->id;
    }

    /**
     * experience
     *
     * @param  mixed  $request
     * @return void
     */
    public function experience($request)
    {
        if (isset($request->experiences) && is_array($request->experiences)) {
            UserExperience::where('user_id', $request->user_id)->delete();
            foreach ($request->experiences as $experience) {
                if (isset($experience['name'])) {
                    UserExperience::create(
                        [
                            'user_id' => $request->user_id,
                            'designation' => $experience['designation'] ?? null,
                            'company_id' => $this->company->companySave($experience['name']),
                            'start_date' => $experience['start_date'] ?? null,
                            'end_date' => isset($experience['is_present']) && $experience['is_present'] == 'on' ? null : customDateFormate($experience['end_date'], $formate = 'y-m-d'),
                            'is_present' => isset($experience['is_present']) && $experience['is_present'] == 'on' ? 1 : 0,
                        ]
                    );
                }
            }
        }
    }
    /**
     * skill
     *
     * @param  Request  $request
     * @return void
     */
    public function skill($request)
    {
        $user = static::$model::firstWhere('id', $request->user_id);
        if ((isset($request->skills) && !empty($request->skills))) {

            $skills = explode(',', $request->skills);
            $exitingSkills = [];
            if (!empty($request->exitingSkills)) {
                $exitingSkills = explode(',', $request->exitingSkills);
            }
            $skillsId = [];

            foreach ($skills as $skill) {
                array_push($skillsId, $this->skill->skillSave($skill));
            }
            if (!empty($exitingSkills) && !empty($skillsId)) {
                $arraySkills = array_unique(array_merge($exitingSkills,  $skillsId));
                $user->skills()->sync($arraySkills);
            } else {
                $exitingSkills ?  $user->skills()->sync($exitingSkills) : $user->skills()->attach($skillsId);
            }
        }
    }

    /**
     * extraInformation
     *
     * @param  Request  $request
     * @return void
     */
    public function extraInformation($request)
    {

        if (isOrganization()) {
            $user = $this->getOrganizationById($request->id);
        }

        if (isInstructor()) {
            $user = $this->getInstructorById($request->id);
        }

        $user->country_id = $request->country_id;
        $user->state_id = $request->state_id;
        $user->city_id = $request->city_id;
        $user->address = $request->address;
        if (isset($request->age) || isset($request->gender)) {
            $user->age = $request->age;
            $user->gender = $request->gender;
        }
        $user->update();
    }

    /**
     * getOrganizationById
     *
     * @param  int  $id
     * @return object
     */
    public function getOrganizationById($id)
    {
        return Organization::firstWhere('id', $id);
    }

    /**
     * getOInstructorById
     *
     * @param  int  $id
     * @return object
     */
    public function getInstructorById($id)
    {
        return Instructor::firstWhere('id', $id);
    }

    /**
     * skillRemove
     *
     * @param  int  $id
     * @return {array}
     */
    public function removeSkill($id): array
    {
        $user = static::$model::firstWhere('id', authCheck()->id);
        if ($user) {
            $user->skills()->detach($id);
            return [
                'status' => 'success',
                'message' => 'Remove successfully.',
                'skills'  =>  $user->skills()->pluck('skill_id')->toArray()
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Something Wrong!',
        ];
    }

    /**
     *  Unified login - checks both Admin and User tables automatically
     */
    public function login(Request $request)
    {
        // Default error message
        $errorMessage = [
            'status' => 'error',
            'message' => 'User not found or credentials are incorrect.',
        ];

        // First, try to authenticate as Admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $authenticatedAdmin = Auth::guard('admin')->user();
            
            // Create a Sanctum token that expires in 1 hour
            $token = $authenticatedAdmin->createToken('auth_token', ['*'], now()->addHours(1))->plainTextToken;
            
            // Regenerate session ID for security
            $request->session()->regenerate();

            return [
                'status' => 'success',
                'message' => translate('Login successfully'),
                'token' => $token,
                'user' => [
                    'id' => $authenticatedAdmin->id,
                    'email' => $authenticatedAdmin->email,
                    'name' => $authenticatedAdmin->name ?? null,
                    'user_type' => 'admin',
                    'guard' => 'admin',
                ],
                'redirect_url' => route('admin.dashboard'),
                'url' => route('admin.dashboard'), // For compatibility with existing JS
            ];
        }

        // If not admin, try to authenticate as User
        $user = User::firstWhere('email', $request->email);
        
        if (!$user) {
            return $errorMessage;
        }

        // Check if email is verified
        if ($user->is_verify != 1) {
            return [
                'status' => 'error',
                'message' => 'Email is not verified.',
            ];
        }

        // Attempt to authenticate the user
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $authenticatedUser = Auth::guard('web')->user();
            
            // Create a Sanctum token that expires in 1 hour
            $token = $authenticatedUser->createToken('auth_token', ['*'], now()->addHours(1))->plainTextToken;
            
            // Regenerate session ID for security
            $request->session()->regenerate();

            // Define dashboard routes based on user guard types
            // Admin and Instructor go to admin dashboard
            $dashboardRoutes = [
                'instructor' => route('admin.dashboard'), // Instructor uses admin dashboard
                'student' => route('student.dashboard'),
                'organization' => route('organization.dashboard'),
            ];

            if ($request->remember_me == "on") {
                $authenticatedUser->update([
                    'remember_me' => Hash::make(random_string())
                ]);
            }

            // Retrieve the authenticated user's guard type and match to route
            $userGuard = $authenticatedUser->guard ?? 'student';
            
            $redirectUrl = $dashboardRoutes[$userGuard] ?? route('home.index');

            return [
                'status' => 'success',
                'message' => translate('Login successfully'),
                'token' => $token,
                'user' => [
                    'id' => $authenticatedUser->id,
                    'email' => $authenticatedUser->email,
                    'username' => $authenticatedUser->username ?? null,
                    'user_type' => $userGuard,
                    'guard' => $userGuard,
                ],
                'redirect_url' => $redirectUrl,
                'url' => $redirectUrl, // For compatibility with existing JS
            ];
        }

        return $errorMessage;
    }

    /**
     *  purchaseCourse
     *
     * @param  array  $coursesId
     */
    public function purchaseCourse($coursesId)
    {
        if ($coursesId) {
            $courses = static::$purchaseDetails::with('course')->whereIn('course_id', $coursesId)->get();

            return $courses;
        }
    }

    public static function forgotPassword(Request $request)
    {
        $rules = [
            'email' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        // If validation failed then return the error.
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors()->toArray(),
            ];
        }
        $user = User::with('userable')->firstWhere('email', $request->email);
        // Default error message if user is not found or other conditions fail
        $message = [
            'status' => 'error',
            'message' => 'Email not found',
        ];
        // If the user exists, proceed with verification checks
        if (!$user) {
            // Check if the email is verified
            return $message;
        }

        $token = Str::random(64);

        $appName = get_theme_option('backend_general') ?? null;
        $userInfo = $user->userable ?? null;
        $userName = $user->name ?? $userInfo->first_name . ' ' .   $user->userable->last_name;
        $data = [
            'user_name' => $userName,
            'email' =>  $user->email,
            'app_name' => $appName['app_name'] ?? 'LMS',
            'token' =>  $token,
        ];
        EmailFormat::forgotPassword($data);


        PasswordReset::create([
            'email' => $request->email,
            'token' =>  $token,
            'created_at' =>  Carbon::now(),
        ]);
        return   $message = [
            'status' => 'success',
            'message' => 'We have e-mailed your password reset link',
        ];
    }



    public static function passwordUpdate(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required|min:6|max:12|confirmed',
        ];
        $validator = Validator::make($request->all(), $rules);
        // If validation failed then return the error.
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors()->toArray(),
            ];
        }
        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();
        if (!$updatePassword) {
            return ['status' => 'error', 'message' => 'Invalid token!'];
        }

        $user = static::$model::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        $updatePassword->delete();
        return [
            'status' => 'success',
            'message' => 'Password Reset Successfully',
            'url' => route('login')
        ];
    }

    public function userExtraInformationDelete($type, $id)
    {
        switch ($type) {
            case 'education':
                $education = UserEducation::where(['user_id' => authCheck()->id, 'id' => $id])->first();
                if ($education) {
                    $education->delete();
                    return [
                        'status' => 'success',
                        'message' => 'Delete Successfully'
                    ];
                }
            case "experience":


                $experience = UserExperience::where(['user_id' => authCheck()->id, 'id' => $id])->first();
                if ($experience) {
                    $experience->delete();
                    return [
                        'status' => 'success',
                        'message' => 'Delete Successfully'
                    ];
                }

            default:
                return [
                    'status' => 'error',
                    'message' => 'Doesn,t match'
                ];
        }
    }


    /**
     * Delete a model.
     *
     * @param  int  $id
     */
    public static function userDelete($id, $data = [], $options = []): array
    {
        return parent::delete($id, $data);
    }



    public static function wishlist()
    {
        $wishlist = Wishlist::with('course.levels', 'course.instructors.userable.translations')->where('user_id', authCheck()->id)->paginate(15);
        return [
            'status' => 'success',
            'data' => $wishlist
        ];
    }

    public static function removeWishlist($id)
    {
        $wishlist = Wishlist::where(['user_id' => authCheck()->id, 'id' => $id])->delete();
        if (!$wishlist) {
            return ['status' => 'error'];
        }
        return ['status' => 'success'];
    }
}
