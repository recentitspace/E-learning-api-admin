<?php

namespace Modules\LMS\Repositories\Cart;

use Modules\LMS\Classes\Cart;
use Modules\LMS\Enums\BundleAuthor;
use Modules\LMS\Enums\DiscountType;
use Modules\LMS\Models\Coupon\Coupon;
use Modules\LMS\Models\Courses\Course;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Modules\LMS\Repositories\Payment\DokuRepository;
use Modules\LMS\Repositories\Payment\PayuRepository;
use Modules\LMS\Repositories\Payment\PaypalRepository;
use Modules\LMS\Repositories\Payment\StripeRepository;
use Modules\LMS\Repositories\Payment\XenditRepository;
use Modules\LMS\Repositories\Payment\PaystackRepository;
use Modules\LMS\Repositories\Payment\RazorpayRepository;

class CartRepository
{
    protected static $course = Course::class;

    protected static $courseBundle = CourseBundle::class;

    protected static $coupon = Coupon::class;



    /**
     *  addToCart
     *
     * @param  int  $id
     * @param  mixed  $request  [type of http request]
     */
    public function addToCart($request)
    {

        try {
            // Validate presence of required fields and check if item already exists in the cart.
            if (empty($request->type) &&  empty($request->id)) {
                return [
                    'status' => 'error',
                    'message' => translate('Invalid item type or ID provided')
                ];
            }

            if (Cart::checkCartExist($request->id)) {
                return [
                    'status' => 'error',
                    'message' => translate('Already in Cart'),
                ];
            }
            // Fetch item details based on type and prepare data for the cart.
            $data = $this->getCartItemData($request->type, $request->id);
            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => translate('Item not found'),
                ];
            }
            Cart::add($data);
            return [
                'status' => 'success',
                'message' => translate('Added to Cart Successfully'),
                'url' => route('cart.page'),
            ];
        } catch (\Throwable $th) {
            // Handle any unexpected errors.
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * Prepare item data for adding to the cart.
     *
     * @param string $type
     * @param int $id
     * @return array|null
     */
    protected function getCartItemData(string $type, int $id): ?array
    {
        switch ($type) {
            case 'bundle':
                $bundle = static::$courseBundle::with('user', 'creator', 'courses')->find($id);

                if (!empty($bundle->creator_type) && $bundle->creator_type == BundleAuthor::ORG) {
                    $userInfo = $bundle?->user?->userable ?? null;
                } else {
                    $userInfo = $bundle?->user?->userable;
                }
                $coursesId  = $bundle?->courses?->pluck('id')->toArray();
                return  [
                    'id' => $bundle->id,
                    'title' => $bundle->title,
                    'slug' => $bundle->slug,
                    'price' => $bundle->price,
                    'type' => 'bundle',
                    'currency' => $bundle->currency ?? 'USD-$',
                    'image' => $bundle->thumbnail,
                    'author' => $userInfo->first_name ??  $userInfo->name ?? null,
                    'review' =>  instructorOrgUser_review($coursesId)
                ];

            case 'course':
                $course = static::$course::with('coursePrice', 'instructors')->find($id);
                $authorName = "";
                foreach ($course->instructors as $instructor) {
                    $authorName = $instructor?->userable?->first_name;
                    break;
                }
                $coursePrice = $this->coursePrice($course);
                return  [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'price' => $coursePrice['regular_price'],
                    'discount_price' => $coursePrice['discount_price'],
                    'type' => 'course',
                    'image' => $course->thumbnail,
                    'currency' => $course?->coursePrice?->currency ?? 'USD-$',
                    'author' => $authorName,
                    'review' =>   review($course)
                ];

            default:
                return null;
        }
    }
    public static function coursePrice($course)
    {
        $discountPrice = 0;
        $regularPrice = 0;
        if (isset($course?->coursePrice) && $course?->coursePrice?->discount_flag == 1 &&   $course?->coursePrice?->discount_period != '' &&  dateCompare($course?->coursePrice?->discount_period) == true) {
            $discountPrice = dotZeroRemove($course?->coursePrice?->discounted_price ?? 0);
            $regularPrice = dotZeroRemove($course?->coursePrice?->price);
        } else {
            $regularPrice = dotZeroRemove($course?->coursePrice?->price ?? 0);
        }
        return ["discount_price" => $discountPrice, "regular_price" => $regularPrice];
    }

    /**
     *  removeCart
     *
     * @param  int  $id
     */
    public function removeCart($id)
    {
        try {

            $cart = Cart::remove($id);

            if (Cart::totalPrice() == 0) {
                session()->flash('discount_amount');
            }

            if ($cart) {
                return [
                    'status' => 'success',
                    'message' => translate('Remove Successfully'),
                    'coupon' => Cart::discountAmount() ?? false,
                    'coupon_amount' => Cart::discountAmount(),
                    'total_amount' => Cart::totalPrice(),
                    'total_qty' => Cart::cartQty(),
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
            return [
                'status' => 'error',
                'message' => '!Something Wrong',
            ];
        }
    }

    public function applyCoupon($couponCode)
    {

        $message = [
            'status' => 'error',
            'message' => translate('Provide The Coupon Code',)
        ];
        if ($couponCode) {
            $coupon = static::$coupon::where(['code' => $couponCode, 'status' => 1])->first();
            if (! $coupon) {
                $message = [
                    'status' => 'error',
                    'message' => 'Coupon Not Found',
                ];
            }
            if (($coupon && $coupon->discount_type == DiscountType::PERCENTAGE) && dateCompare($coupon->expiration_date)) {
                return  $this->couponAmount($coupon->max_amount);
            }

            if (($coupon && $coupon->discount_type == DiscountType::FIXED) && dateCompare($coupon->expiration_date)) {
                return  $this->couponAmount($coupon->max_amount);
            }
        }
        return $message;
    }

    public function couponAmount($max_amount)
    {
        if ($max_amount > Cart::totalPrice()) {
            return  [
                'status' => 'error',
                'message' => 'You are not applicable',
            ];
        }
        Session::put('discount_amount', $max_amount);
        return [
            'status' => 'success',
            'message' => translate('Thank Your For Apply Coupon'),
            'coupon' => true,
            'coupon_amount' => Cart::discountAmount(),
            'total_amount' => Cart::totalPrice(),
        ];
    }
}
