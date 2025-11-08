<?php

namespace Modules\LMS\Models\Hero;

use Modules\LMS\Models\Theme\Theme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\Slider\Slider;

class Hero extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];


    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function sliders(): HasMany 
    {
        return $this->hasMany(Slider::class);
    }
}
