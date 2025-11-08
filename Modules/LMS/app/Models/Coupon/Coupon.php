<?php

namespace Modules\LMS\Models\Coupon;

use Modules\LMS\Models\Category;
use Modules\LMS\Models\Courses\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "coupons";
    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'coupon_categories', 'coupon_id', 'category_id')->withTimestamps();
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'coupon_courses', 'coupon_id', 'course_id')->withTimestamps();
    }

    public function courseBundles(): BelongsToMany
    {
        return $this->belongsToMany(CourseBundle::class, 'course_bundles', 'coupon_id', 'course_bundle_id')->withTimestamps();
    }
}
