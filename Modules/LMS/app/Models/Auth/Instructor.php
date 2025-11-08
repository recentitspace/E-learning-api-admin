<?php

namespace Modules\LMS\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\Designation;
use Modules\LMS\Models\DynamicContentTranslation;
use Modules\LMS\Models\Localization\City;
use Modules\LMS\Models\Localization\Country;
use Modules\LMS\Models\Localization\State;
use Modules\LMS\Models\User;

class Instructor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the user's image.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
