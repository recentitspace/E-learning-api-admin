<?php

namespace Modules\LMS\Repositories\Purchase;

use Modules\LMS\Models\User;
use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Enums\PurchaseStatus;
use Modules\LMS\Models\Courses\Course;
use Illuminate\Support\Facades\Validator;
use Modules\LMS\Models\Purchase\Purchase;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Repositories\Cart\CartRepository;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Modules\LMS\Repositories\Order\OrderRepository;


class PurchaseRepository extends BaseRepository
{
    protected static $model = PurchaseDetails::class;
    protected static $purchase = Purchase::class;

    protected static $rules = [
        'save' => [
            'student_id' => 'required',
            'courses' => 'required',
        ],

    ];

    /**
     *  courseEnroll
     *
     * @param  mixed  request
     * @param int  userId
     */
    public function courseEnroll($request, $userId): array
    {
        $validator = Validator::make($request->all(), static::$rules['save']);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors()->toArray(),
            ];
        }
        $coursePrice = 0;
        $discountPrice = 0;

        foreach ($request->courses  as  $courseId) {
            $course = $this->courseGetById($courseId);
            $response =  CartRepository::coursePrice($course);
            $coursePrice += $response['regular_price'];
            $discountPrice += $response['discount_price'];
        }
        $data = [
            'user_id' => $userId,
            'type' => PurchaseType::ENROLLED,
            'status' => 'success',
            'total_amount' =>  $coursePrice,
            'payment_method' =>  'offline',
        ];
        $purchase = $this->purchaseStore($data);
        foreach ($request->courses as $courseId) {
            if (! static::$model::where(['user_id' => $userId, 'course_id' => $courseId])->exists()) {
                $course = $this->courseGetById($courseId);
                $response =  CartRepository::coursePrice($course);
                $discount_price = $response['discount_price'] - ($item->coursePrice->platform_fee ??  $course->platform_fee);
                if ($course) {
                    $purchaseDetail = [
                        'purchase_id' => $purchase->id,
                        'course_id' => $courseId,
                        'user_id' => $userId,
                        'bundle_id' => null,
                        'price' => $response['regular_price'] - ($item->coursePrice->platform_fee ??  $course->platform_fee),
                        'platform_fee' => $item->coursePrice->platform_fee ??  $course->platform_fee ?? 0,
                        'discount_price' => $discount_price,
                        'details' => $course,
                        'type' => PurchaseType::ENROLLED,
                        'purchase_type' => PurchaseType::COURSE,
                        'status' => PurchaseStatus::PROCESSING

                    ];
                    OrderRepository::purchaseDetails($purchaseDetail);
                }
                OrderRepository::profitShareCalculate($course,  $discount_price);
            }
        }

        return [
            'status' => 'success',
        ];
    }

    /**
     *  courseEnroll
     *
     * @param  mixed  request
     * @param  int  userId
     */
    public function courseGetById($id)
    {
        return Course::with('coursePrice')
            ->firstWhere('id', $id);
    }

    /**
     *  courseEnroll
     *
     * @param  int  $item
     */
    public function enrollments($item = 10)
    {
        $data = static::$model::with('user.userable.translations', 'course.instructors.userable.translations', 'courseBundle.instructor',  'courseBundle.organization')
            ->latest()
            ->where('type', PurchaseType::ENROLLED)
            ->paginate($item);
        return $data;
    }
    /**
     * courseEnrolled
     *
     * @param  mixed  $request
     */
    public function courseEnrolled($request)
    {

        try {
            if (is_free($request->id, type: $request->type ?? null)) {
                $userId = authCheck()->id;
                $type = $request->type ?? 'course';

                // Prepare data for purchase record.
                $purchaseData = [
                    'user_id' => $userId,
                    'type' => PurchaseType::ENROLLED,
                    'status' => 'success',
                ];

                $purchase = $this->purchaseStore($purchaseData);

                // Retrieve course or bundle information based on the request type.
                $courseInfo = $type === 'bundle'
                    ? CourseBundle::findOrFail($request->id)
                    : Course::with('coursePrice')->findOrFail($request->id);

                // Create a new record in the model with appropriate fields set.
                static::$model::create([
                    'purchase_number' => strtoupper(orderNumber()),
                    'purchase_id' => $purchase->id,
                    'user_id' => $userId,
                    'course_id' => $type === 'course' ? $courseInfo->id : null,
                    'bundle_id' => $type === 'bundle' ? $courseInfo->id : null,
                    'details' => $courseInfo,
                    'type' => PurchaseType::ENROLLED,
                    'purchase_type' => $type === 'bundle' ? PurchaseType::BUNDLE : PurchaseType::COURSE,
                ]);

                return [
                    'status' => 'success'
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     *  courseEnroll
     *
     * @param  int  $item
     */
    public function purchaseFirst($id)
    {
        return static::$model::with('user.userable', 'course.instructors.userable', 'courseBundle.instructor.userable', 'courseBundle.organization.userable')
            ->latest()
            ->where('type', PurchaseType::ENROLLED)
            ->where('id', $id)
            ->first();
    }

    /**
     *  purchaseStore
     * @param array $data 
     */
    public function purchaseStore($data)
    {
        $purchase = static::$purchase::create($data);
        return $purchase;
    }

    /**
     *  getByUserId
     * @param array $data 
     */
    public static function getByUserId($data)
    {
        if (bundle_course_check($data['course_id']) ||  static::$model::where($data)->first()) {
            return true;
        }
        return false;
    }

    public static function salesReports(): array
    {
        $data['total_sales'] = static::$model::sum('price');
        $data['total_platform_fee'] = static::$model::sum('platform_fee');
        $data['total_course_sale'] = static::$model::where('purchase_type', PurchaseType::COURSE)->sum('price');
        $data['total_bundle_sale'] = static::$model::where('purchase_type', PurchaseType::BUNDLE)->sum('price');
        return $data;
    }


    public static function authSalesReports(): array

    {
        $courseId = [];
        if (isOrganization()) {
            $courseId = authCheck()?->organizationCourses?->pluck('id')->toArray() ?? [];
        }
        if (isInstructor()) {
            $user = User::where('id', authCheck()->id)
                ->withWhereHas(
                    'courses',
                    function ($query) {
                        $query->where('organization_id', '=', null);
                    }
                )
                ->first();
            $courseId = $user?->courses?->pluck('id')->toArray() ?? [];
        }

        $data['total_sales'] =  static::$model::whereIn('course_id', $courseId)->sum('price');
        $data['total_platform_fee'] =  static::$model::whereIn('course_id', $courseId)->sum('platform_fee');
        $data['total_course_sale'] =  static::$model::whereIn('course_id', $courseId)->where('purchase_type', PurchaseType::COURSE)->sum('price');
        $data['total_bundle_sale'] =   static::$model::whereIn('course_id', $courseId)->where('purchase_type', PurchaseType::BUNDLE)->sum('price');
        return $data;
    }
}
