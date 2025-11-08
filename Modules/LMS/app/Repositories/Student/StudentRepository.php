<?php

namespace Modules\LMS\Repositories\Student;

use Illuminate\Support\Facades\Hash;
use Modules\LMS\Classes\EmailFormat;
use Modules\LMS\Classes\NotificationFormat;
use Modules\LMS\Enums\EnrollmentStatus;
use Modules\LMS\Enums\ExamType;
use Modules\LMS\Enums\PurchaseStatus;
use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Auth\Admin;
use Modules\LMS\Models\Auth\Student;
use Modules\LMS\Models\Auth\UserCourseExam;
use Modules\LMS\Models\Certificate\UserCertificate;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Models\User;
use Modules\LMS\Repositories\BaseRepository;

class StudentRepository extends BaseRepository
{
    protected static $model = Student::class;
    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,guard',
            'password' => 'required|min:6|max:12|confirmed',
            'phone' => 'required|unique:students,phone',
        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['password', 'password_confirmation', 'user_type', 'email', '_token', 'image', 'locale'],
        'update' => ['_token', 'password', 'password_confirmation', '_method', 'user_type', 'email', 'image', 'locale'],
    ];


    /**
     * @param  int  $id
     * @param  mixed  $request
     */
    public static function save($request): array
    {

        try {
            // Handle image upload if an image file is present in the request.
            if ($request->hasFile('image')) {
                static::$rules['save']['image'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
                // Upload the image and retrieve the file path.
                $imagePath = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/students');

                // Attach the uploaded image path to the request data.
                $request->merge(['profile_img' => $imagePath]);
            }

            // Attempt to save the student data from the request.
            $response = parent::save($request->all());

            // Check if the student save operation was successful.
            if ($response['status'] === 'success') {
                $studentData = $response['data'];

                // Create a new user associated with the student.
                $user = $studentData->user()->create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password), // Securely hash the password.
                    'guard' => 'student',
                    'is_verify' => 0, // Set initial verification status.
                    'username' => $request->first_name . ' ' . $request->last_name, // Set username from first_name and last_name
                ]);

                // Assign the 'Student' role to the newly created user.
                $user->assignRole('Student');

                $setting = get_theme_option('backend_general') ?? null;
                // Prepare data for registration notification and email.
                $notificationData = [
                    'user_name' => $studentData->first_name,
                    'email' => $request->email,
                    'id' => $user->id,
                    'role' => 'Student',
                    'token' => Hash::make('first_name'), // Consider implementing a more secure token generation.
                    'app_name' => $setting['app_name'] ?? 'LMS Hub',
                ];

                // Prepare notification data for the admin.
                $adminNotificationData = [
                    'user_name' => "{$studentData->first_name} {$studentData->last_name}",
                    'role' => 'Student',
                    'created_at' => customDateFormate($user->created_at, 'M d Y H:i a'),
                ];

                // Send a registration email to the new user.
                EmailFormat::registrationMail($notificationData);

                // Notify all admins about the new student registration.
                NotificationFormat::notificationToAdmin(Admin::all(), $adminNotificationData);

                if ($user?->userable) {
                    $userableData = self::translateData($request->all());
                    self::translate($user?->userable, $userableData, locale: $request->locale ?? app()->getLocale());
                }
            }

            // Return the response containing the student data.
            return $response;
        } catch (\Throwable $th) {
            // Return an error response in case of an exception.
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * @param  int  $id
     * @param  mixed  $request
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

        static::$rules['update'] = [
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|unique:students,phone,' . $user?->userable?->id,

        ];
        if (!empty($request->password)) {
            static::$rules['update']['password'] = 'required|min:5|max:12|confirmed';
            $user->update([
                'password' => $request->password,
            ]);
        }

        if ($request->hasFile('image')) {
            static::$rules['update']['image'] = 'required|image|mimes:jpg,png,svg,webp,jpeg';
            $image = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/students');
            $request->request->add([
                'profile_img' => $image,
            ]);
        }

        return parent::update($user?->userable?->id, $request->all());
    }

    /**
     *  dashboardReport
     *
     * @return array
     */
    public function dashboardReport()
    {
        $data['enrolled'] = $this->courseEnrolled();
        $data['totalEnrolled'] = $this->courseEnrolledCount();
        $data['latestCourses'] = $this->latestCourse();
        $data['totalProcessing'] = $this->courseGetByStatus(EnrollmentStatus::PROCESSING)?->count();
        $data['totalCompleted'] = $this->courseGetByStatus(EnrollmentStatus::COMPLETED)?->count();
        $data['totalCertificate'] = UserCertificate::where('user_id', authCheck()->id)->count();

        return $data;
    }

    /**
     * latestCourse
     *
     * @return object
     */
    public function latestCourse()
    {
        return PurchaseDetails::with('course')
            ->where([
                'user_id' => authCheck()->id,
                'type' => PurchaseType::PURCHASE,
            ])
            ->where('status', '!=', PurchaseStatus::PENDING)
            ->latest()
            ->take(6)
            ->get();
    }

    /**
     *  courseGetByStatus
     *
     * @param  string  $courseStatus
     * @return object
     */
    public function courseGetByStatus($courseStatus)
    {
        return PurchaseDetails::where(['user_id' => authCheck()->id, 'status' => $courseStatus])
            ->get();
    }

    /**
     * statusChange
     *
     * @param  int  $id
     * @return array
     */
    public function statusChange($id)
    {
        // Fetch the student record by ID.
        $student = static::$model::firstWhere('id', $id);

        // Check if the student was not found.
        if (!$student) {
            return [
                'status' => 'error',
                'message' => translate('Something went wrong! Student not found.'),
            ];
        }

        // Toggle the student's status (activate/deactivate).
        $student->status = !$student->status;
        $student->update();

        // Prepare notification data based on the new status.
        $data = [
            'status' => $student->status ? 'activated' : 'deactivated', // Use a boolean condition for clarity.
            'user_name' => "{$student->first_name} {$student->last_name}",
            'email' => $student->user->email ?? translate('No email provided'), // Use null coalescing for safety.
            'app_name' => config('app.name'),
        ];

        // Send notifications regarding the account status change.
        NotificationFormat::notifyAccountStatus($student->user, $data);
        EmailFormat::accountStatusChange($data);

        // Return a success response indicating the status change was successful.
        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.'),
        ];
    }

    /**
     * purchaseCourses
     *
     * @return object
     */
    public function courseEnrolled($item = null)
    {
        $model = PurchaseDetails::query();
        $model->where([
            'user_id' => authCheck()->id,
            'type' => PurchaseType::ENROLLED,
        ]);
        $purchaseModel = $model->with('course.category', 'course.coursePrice', 'course.levels.translations', 'course.subject', 'course.courseSetting', 'course.instructors.userable', 'courseBundle.courses.instructors.userable', 'courseBundle.translations');
        return $item ? $purchaseModel->paginate($item) : $purchaseModel->get();
    }

    /**
     * courseEnrolledCount
     *
     * @return int
     */
    public function courseEnrolledCount(): int
    {
        $model = PurchaseDetails::query();
        $purchase =  $model->where([
            'user_id' => authCheck()->id,
            'type' => PurchaseType::ENROLLED,
        ])->count();

        return $purchase;
    }


    /**
     * purchaseCourses
     *
     * @return object
     */
    public function purchaseCourses()
    {

        $query = PurchaseDetails::with('course.coursePrice', 'course.levels')
            ->where(['user_id' => authCheck()->id, 'type' => PurchaseType::PURCHASE])
            ->where('status', '!=', PurchaseStatus::PENDING)
            ->whereNotNull('course_id')
            ->select('id', 'purchase_id', 'course_id', 'bundle_id', 'user_id', 'price');

        // Check if subscription module is active
        if (module_enable_check('subscribe')) {
            $query->addSelect('subscribe_id');
        }

        return $query->paginate(10);
    }

    /**
     *  bundlePurchases
     *
     * @return object
     */
    public function bundlePurchases()
    {

        $query = PurchaseDetails::with('courseBundle.courses')
            ->where([
                'user_id' => authCheck()->id,
                'type' => PurchaseType::PURCHASE
            ])
            ->where('status', '!=', PurchaseStatus::PENDING)
            ->whereNotNull('bundle_id')
            ->select('id', 'purchase_id', 'course_id', 'bundle_id', 'user_id', 'price');

        // Check if subscription module is active
        if (module_enable_check('subscribe')) {
            $query->addSelect('subscribe_id');
        }
        return $query->paginate(10);
    }

    /**
     * getUserExamType
     *
     * @return array|object
     */
    public function getUserExamType($type = null)
    {
        // Check if the exam type is provided.
        if ($type) {
            // Initialize the query for UserCourseExam.
            $userCourseExam = UserCourseExam::query();

            // Eager load relationships based on the exam type using match.
            match ($type) {
                ExamType::ASSIGNMENT => $userCourseExam->with(['assignment', 'sourceFiles']),
                ExamType::QUIZ => $userCourseExam->with(['quiz']),
                // You can add more cases here if needed.
                default => null, // Handle unexpected exam types if necessary (optional).
            };

            // Fetch the paginated results for the user, including related user and course data.
            return $userCourseExam->with(['user', 'course'])
                ->where('user_id', authCheck()->id)
                ->where('exam_type', $type)
                ->paginate(10);
        }

        // Return an empty array if no exam type is specified.
        return [];
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
