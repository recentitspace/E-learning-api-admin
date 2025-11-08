<?php

namespace Modules\LMS\Traits;

use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Models\Courses\Bundle\BundleCourse;

trait ChecksUserPurchasesTrait
{

    /**
     * Get the purchase type dynamically.
     *
     * @return string The purchase type (e.g., 'course' or 'bundle').
     */
    public function getPurchaseType(): string
    {
        return $this->detectPurchaseType();
    }

    /**
     * Get the purchase ID column dynamically based on the model name.
     *
     * @return string The database column name (e.g., 'course_id' or 'bundle_id').
     */
    public function getPurchaseIdColumn(): string
    {
        return $this->detectPurchaseType() . '_id';
    }

    /**
     * Detect the purchase type based on the model class name.
     *
     * @return string The detected purchase type (e.g., 'course' or 'bundle').
     */
    private function detectPurchaseType(): string
    {
        $className = class_basename($this); // Get the model class name

        if (stripos($className, 'bundle') !== false) {
            return 'bundle'; // If 'bundle' exists in class name, return 'bundle'
        }
        return 'course'; // Default to 'course'
    }
    /**
     * Retrieve the purchase item for a given user.
     *
     * @param mixed $user The user object (optional, defaults to authenticated user).
     * @return mixed|null The purchase item if found, otherwise null.
     */

    public function getPurchaseItem($user = null)
    {


        if (empty($user)) {
            $user = authCheck();
        }
        if (!empty($user)) {
            return PurchaseDetails::query()->where('user_id', $user->id)
                ->where($this->getPurchaseIdColumn(), $this->id)
                ->where('purchase_type',  $this->getPurchaseType())
                ->orderBy('created_at', 'desc')
                ->first();
        }


        return null;
    }




    /**
     * Check if the user has purchased the item.
     *
     * @param mixed $user The user object (optional, defaults to authenticated user).
     * @param bool $checkExpired Whether to check if the subscription is expired.
     * @param bool $test Reserved for testing purposes (not currently used).
     * @return bool True if the user has an active purchase, otherwise false.
     */
    public function hasUserPurchased($user = null): bool
    {
        $hasPurchased = false;



        if (empty($user) && authCheck()) {
            $user = authCheck();
        }

        if (empty($user)) {
            return false;
        }
        $purchaseItem = $this->getPurchaseItem($user);
        if (empty($purchaseItem)) {
            $hasPurchased = false;
        }


        // If it's not a subscription, mark it as purchased
        if ($purchaseItem) {
            if ($purchaseItem->subscribe_id) {
                $subscribe = $purchaseItem->getUsedSubscribe($purchaseItem?->user_id, $purchaseItem?->course_id ??  $purchaseItem?->bundle_id, $purchaseItem?->id, type: $this->detectPurchaseType());
                if (!empty($subscribe)) {
                    // Get the latest subscription purchase
                    $subscribeSale = PurchaseDetails::where('user_id', $user->id)
                        ->where('purchase_type', PurchaseType::SUBSCRIBE)
                        ->where('subscribe_id', $subscribe->id)
                        ->latest('created_at')
                        ->first();

                    // Check if subscription is still valid
                    if (!empty($subscribeSale)) {
                        $usedDays = (int) get_diff_timestamp_day(now(), $subscribeSale->created_at);
                        if ($usedDays <= $subscribe->days) {
                            $hasPurchased = true;
                        }
                    }
                }
            } else {
                $hasPurchased = true;
            }
        }
        if (!$hasPurchased &&  $this->detectPurchaseType() ==  "course") {
            $bundleCourses = BundleCourse::with('bundle')->where('course_id', $this->id)->get();
            if (count($bundleCourses) > 0) {
                foreach ($bundleCourses as $item) {
                    if ($item->bundle && $item->bundle?->hasUserBundlePurchased($user)) {
                        $hasPurchased = true;
                    }
                }
            }
        }
        return $hasPurchased;
    }
}
