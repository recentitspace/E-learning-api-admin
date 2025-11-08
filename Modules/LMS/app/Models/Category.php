<?php

namespace Modules\LMS\Models;

use Modules\LMS\Models\Courses\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'category_id', 'id');
    }


    public function icon()
    {

        return $this->belongsTo(Icon::class, 'icon_id', 'id');
    }

    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
