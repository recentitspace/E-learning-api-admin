<?php

namespace Modules\LMS\Repositories\Coupon;

use Modules\LMS\Enums\CouponType;
use Modules\LMS\Enums\DiscountType;
use Modules\LMS\Models\Coupon\Coupon;
use Modules\LMS\Repositories\BaseRepository;

class CouponRepository extends BaseRepository
{
    protected static $model = Coupon::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['categoryId', 'courseId', '_token'],
        'update' => ['categoryId', 'courseId', '_token', '_method'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:coupons,name',
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'discount_type' => 'required',
        ],
        'update' => [],
    ];

    /**
     * save
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        // Define the base rules for the coupon validation.
        $baseRules = [
            'name' => 'required|unique:coupons,name',
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
        ];

        // Add additional rules based on the discount type.
        if ($request->discount_type == DiscountType::PERCENTAGE) {
            $additionalRules = [
                'discount_percentage' => 'required',
                'max_amount' => 'required',
            ];
        } elseif ($request->discount_type == DiscountType::FIXED) {
            $additionalRules = [
                'max_amount' => 'required',
            ];
        } else {
            // Handle invalid discount types, if necessary
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid discount type.'
            ]);
        }

        // Combine base rules with additional rules.
        static::$rules['save'] = array_merge($baseRules, $additionalRules);

        // Attempt to save the coupon and capture the response.
        $coupon = parent::save($request->all());

        // Check if the coupon was saved successfully.
        if ($coupon['status'] == 'success') {
            self::saveCouponValue($coupon['data'], $request->type, $request, 'save');
        }

        return $coupon;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        if ($request->discount_type == DiscountType::PERCENTAGE) {
            static::$rules['update'] = [
                'name' => 'required|unique:coupons,name,' . $id,
                'code' => 'required|unique:coupons,code,' . $id,
                'type' => 'required',
                'discount_percentage' => 'required',
                'max_amount' => 'required',
            ];
        } elseif ($request->discount_type == DiscountType::FIXED) {
            static::$rules['update'] = [
                'name' => 'required|unique:coupons,name,' . $id,
                'code' => 'required|unique:coupons,code,' . $id,
                'type' => 'required',
                'max_amount' => 'required',
            ];
        }

        static::$rules['update'] = [
            'name' => 'required|unique:coupons,name,' . $id,
            'code' => 'required|unique:coupons,code,' . $id,
            'type' => 'required',
            'discount_type' => 'required',
        ];
        $coupon = parent::update($id, $request->all());
        if ($coupon['status'] == 'success') {
            self::saveCouponValue($coupon['data'], $request->type, $request, $action = 'update');
        }

        return $coupon;
    }

    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $coupon = parent::first($id);
        if ($coupon['status'] == 'success') {
            $data = $coupon['data'];
            $data->delete();
        }

        return $coupon;
    }

    /**
     *  saveCouponValue
     *
     * @param  object  $coupon
     * @param  string  $type
     * @param  mixed  $request
     * @param  string  $action
     */
    protected static function saveCouponValue($coupon, $type, $request, $action)
    {

        // Determine the relationship and corresponding ID based on the coupon type and action.
        switch ($type) {
            case CouponType::CATEGORY:
                $relationMethod = 'categories';
                $id = $request->categoryId;
                break;

            case CouponType::COURSE:
                $relationMethod = 'courses';
                $id = $request->courseId;
                break;

            case CouponType::BUNDLE:
                $relationMethod = 'courses'; // Bundles also use the courses relationship
                $id = $request->bundleId;
                break;

            default:
                return; // Handle an unexpected coupon type, if necessary
        }

        // Perform the action (attach or sync) based on the provided action type.
        if ($action == 'save') {
            $coupon->{$relationMethod}()->attach($id);
        } else {
            $coupon->{$relationMethod}()->sync($id);
        }
    }

    /**
     *  statusChange
     */
    public function statusChange($id): array
    {
        $coupon = parent::first($id);
        $coupon = $coupon['data'];
        $coupon->status = ! $coupon->status;
        $coupon->update();
        return [
            'status' => 'success',
            'message' => translate('Status Change Successfully')
        ];
    }
}
