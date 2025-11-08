<?php

namespace Modules\LMS\Models\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\DynamicContentTranslation;

class Level extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function courses(): BelongsToMany
    {

        return $this->belongsToMany(Course::class, 'course_levels', 'level_id', 'course_id')->withTimestamps();
    }

    /**
     * Get the user's image.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
