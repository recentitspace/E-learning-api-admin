<?php

namespace Modules\LMS\Models\SupportTicket;

use Illuminate\Database\Eloquent\Model;
use Modules\LMS\Models\DynamicContentTranslation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    /**
     * Get the category translations'.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
