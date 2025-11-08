<?php

namespace Modules\LMS\Models\Localization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\LMS\Models\DynamicContentTranslation;
use Modules\LMS\Models\Language;

class Localization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the user's image.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
