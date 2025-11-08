<?php

namespace Modules\LMS\Models\Courses;

use Modules\LMS\Models\User;
use Modules\LMS\Models\Category;
use Modules\LMS\Models\Language;
use Modules\LMS\Models\Outcomes;
use Modules\LMS\Enums\PurchaseType;
use Illuminate\Database\Eloquent\Model;
use Modules\LMS\Models\Auth\UserCourseExam;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Traits\ChecksUserPurchasesTrait;
use Modules\LMS\Models\DynamicContentTranslation;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory, SoftDeletes, ChecksUserPurchasesTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class, 'course_levels', 'course_id', 'level_id')
            ->withTimestamps()->withTrashed();
    }

    public function instructors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_instructors', 'course_id', 'instructor_id')
            ->withTimestamps()->withTrashed()->withPivot('id', 'percentage',  'is_main');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'course_languages', 'course_id', 'language_id')
            ->withTimestamps()->withTrashed();
    }

    public function courseOutComes(): BelongsToMany
    {
        return $this->belongsToMany(Outcomes::class, 'course_outcomes', 'course_id', 'outcomes_id')
            ->withTimestamps();
    }

    public function relatedCourse()
    {
        return $this->belongsToMany(Course::class, 'related_courses', 'course_id', 'related_id')
            ->withTimestamps();
    }

    public function courseRequirements(): BelongsToMany
    {
        return $this->belongsToMany(Requirement::class, 'course_requirements', 'course_id', 'requirement_id')
            ->withTimestamps();
    }

    public function courseTags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'course_tags', 'course_id', 'tag_id')
            ->withTimestamps();
    }

    public function courseFaqs(): HasMany
    {
        return $this->hasMany(CourseFaq::class);
    }

    public function coursePrice(): HasOne
    {
        return $this->hasOne(CoursePrice::class);
    }

    public function courseSetting(): HasOne
    {
        return $this->hasOne(CourseSetting::class)->withTrashed();
    }

    public function coursePreviews(): HasMany
    {
        return $this->hasMany(CoursePreviewImage::class);
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)
            ->orderBy('order')->withTrashed();
    }

    public function courseNotes(): HasMany
    {
        return $this->hasMany(CourseNoticeboard::class);
    }

    public function meetProvider(): HasOne
    {
        return $this->hasOne(CourseMeetProvider::class);
    }

    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'purchase_details', 'course_id', 'user_id')
            ->wherePivot('type', PurchaseType::ENROLLED)
            ->withTrashed();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function totalPurchases(): HasMany
    {
        return $this->hasMany(PurchaseDetails::class, 'course_id', 'id');
    }
    public function purchases(): HasMany
    {
        return $this->hasMany(PurchaseDetails::class, 'course_id', 'id')->withTrashed();
    }
    public function scopeSaleCountNumber($query)
    {
        return $query->addSelect([
            'sale_count_number' => CourseSetting::select('sale_count_number')
                ->whereColumn('course_id', 'courses.id'),
        ]);
    }
    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(CourseBundle::class, 'course_bundle_courses', 'course_bundle_id', 'course_id')
            ->withTimestamps();
    }

    public function courseExams(): HasMany
    {
        return $this->hasMany(UserCourseExam::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($course) {
            if ($course->isForceDeleting()) {
                // Force delete related states and cities
                $course->chapters()->withTrashed()->each(function ($chapter) {
                    $chapter->withTrashed()->forceDelete();
                });
                $course->purchases()->withTrashed()->each(function ($purchase) {
                    $purchase->withTrashed()->forceDelete();
                });

                $course->courseNotes()->withTrashed()->each(function ($courseNote) {
                    if (static::isSoftDeleteEnable($courseNote)) {
                        $courseNote->withTrashed()->forceDelete();
                    }
                });

                $course->purchases()->withTrashed()->each(function ($purchase) {
                    if (static::isSoftDeleteEnable($purchase)) {
                        $purchase->withTrashed()->forceDelete();
                    }
                });

                $course->courseExams()->withTrashed()->each(function ($courseExam) {
                    if (static::isSoftDeleteEnable($courseExam)) {
                        $courseExam->withTrashed()->forceDelete();
                    }
                });

                $course->courseSetting()->forceDelete();
                $course->bundles()->forceDelete();
            } else {
                // Soft delete related states and cities


                $course->chapters()->each(function ($chapter) {
                    $chapter->delete();
                });
                $course->purchases()->each(function ($purchase) {
                    $purchase->delete();
                });

                $course->courseExams()->each(function ($courseExam) {
                    if (static::isSoftDeleteEnable($courseExam)) {
                        $courseExam->forceDelete();
                    }
                });
                $course->courseSetting()->delete();
                $course->courseNotes()->delete();
                $course->bundles()->delete();
            }
        });

        // Handle restoring related states and cities
        static::restored(function ($course) {
            // Restore related states
            $course->chapters()->withTrashed()->each(function ($chapter) {
                // Restore related cities
                if (static::isSoftDeleteEnable($chapter)) {
                    $chapter->withTrashed()->restore();
                }
            });
            $course->purchases()->withTrashed()->each(function ($purchase) {
                if (static::isSoftDeleteEnable($purchase)) {
                    $purchase->withTrashed()->restore();
                }
            });
            $course->courseNotes()->withTrashed()->each(function ($courseNote) {
                if (static::isSoftDeleteEnable($courseNote)) {
                    $courseNote->withTrashed()->restore();
                }
            });

            $course->courseExams()->withTrashed()->each(function ($courseExam) {
                if (static::isSoftDeleteEnable($courseExam)) {
                    $courseExam->withTrashed()->restore();
                }
            });
            $course->courseSetting()->restore();
            $course->bundles()->delete();
        });
    }

    public static function isSoftDeleteEnable($class)
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($class));
    }

    /**
     * Get the user's image.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
