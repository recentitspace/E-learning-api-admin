<?php

namespace Modules\LMS\Models\Localization;

use Illuminate\Database\Eloquent\Model;
use Modules\LMS\Models\Auth\Instructor;
use Modules\LMS\Models\Auth\Organization;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LMS\Models\Courses\Course;

class TimeZone extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function instructors(): HasMany
    {
        return $this->hasMany(Instructor::class);
    }

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }


    public function courses(): HasMany
    {
        return $this->hasMany(Course::class)->withTrashed();
    }



    protected static function boot()
    {
        parent::boot();

        // Handle soft deleting related states and cities
        static::deleting(function ($timeZone) {
            if ($timeZone->isForceDeleting()) {
                // Force delete related states and cities
                $timeZone->courses()->withTrashed()->each(function ($course) {
                    $course->chapters()->withTrashed()->forceDelete();
                    $course->courseSetting()->withTrashed()->forceDelete();
                    $course->forceDelete();
                });
            } else {
                // Soft delete related states and cities
                $timeZone->courses()->each(function ($course) {
                    $course->chapters()->delete();
                    $course->courseSetting()->delete();
                    $course->delete();
                });
            }
        });

        // Handle restoring related states and cities
        static::restored(function ($timeZone) {
            // Restore related states
            $timeZone->courses()->withTrashed()->each(function ($course) {
                // Restore related cities
                $course->chapters()->withTrashed()->restore();
                $course->restore();
            });
        });
    }
}
