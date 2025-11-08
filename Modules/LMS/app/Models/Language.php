<?php

namespace Modules\LMS\Models;

use Modules\LMS\Models\Courses\Course;
use Illuminate\Database\Eloquent\Model;
use Modules\LMS\Models\Auth\Instructor;
use Modules\LMS\Models\Auth\Organization;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\DynamicContentTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function courses()
    {

        return $this->belongsToMany(Course::class, 'course_languages', 'language_id', 'course_id')->withTimestamps();
    }

    public function instructors(): HasMany
    {
        return $this->hasMany(Instructor::class);
    }

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }


    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
