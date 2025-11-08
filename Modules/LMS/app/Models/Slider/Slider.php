<?php

namespace Modules\LMS\Models\Slider;

use Modules\LMS\Models\Hero\Hero;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LMS\Models\DynamicContentTranslation;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];


    protected $casts = [
        'buttons' => 'array',
    ];


    public function hero(): BelongsTo
    {

        return $this->belongsTo(Hero::class);
    }

    /**
     * Get the user's image.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
