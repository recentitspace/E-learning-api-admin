<?php

namespace Modules\LMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DynamicContentTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['locale', 'translationable_id', 'translationable_type', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the model that the image belongs to.
     */
    public function translationable(): MorphTo
    {
        return $this->morphTo();
    }
}
