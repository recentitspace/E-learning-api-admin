<?php

namespace Modules\LMS\Models\Courses\Bundle;

use Modules\LMS\Models\User;
use Modules\LMS\Models\Category;
use Modules\LMS\Models\Outcomes;
use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Courses\Level;
use Modules\LMS\Models\Courses\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Traits\ChecksUserPurchasesTrait;
use Modules\LMS\Models\DynamicContentTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseBundle extends Model
{
    use HasFactory, SoftDeletes, ChecksUserPurchasesTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_bundle_courses', 'course_bundle_id', 'course_id')
            ->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class, 'bundle_level', 'bundle_id', 'level_id')
            ->withTimestamps()->withTrashed();
    }

    public function bundleOutComes(): BelongsToMany
    {
        return $this->belongsToMany(Outcomes::class, 'bundle_outcome', 'bundle_id', 'outcomes_id')
            ->withTimestamps();
    }

    public function bundleFaqs(): HasMany
    {
        return $this->hasMany(BundleFaq::class, 'bundle_id', 'id');
    }
    /**
     * Get the bundle's translation.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }


    public function getPurchaseItem($user = null)
    {
        if (empty($user)) {
            $user = authCheck();
        }
        if (!empty($user)) {
            return PurchaseDetails::query()->where('user_id', $user->id)
                ->where('bundle_id', $this->id)
                ->where('purchase_type', 'bundle')
                ->orderBy('created_at', 'desc')
                ->first();
        }
        return null;
    }

    public function hasUserBundlePurchased($user = null)
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
                $subscribe = $purchaseItem->getUsedSubscribe($purchaseItem?->user_id, $purchaseItem?->bundle_id, $purchaseItem?->id, type: "bundle");
                if (!empty($subscribe)) {
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
        return $hasPurchased;
    }
}
