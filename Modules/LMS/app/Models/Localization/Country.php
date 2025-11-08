<?php

namespace Modules\LMS\Models\Localization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\LMS\Models\DynamicContentTranslation;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
    protected static function boot()
    {
        parent::boot();

        // Handle soft deleting related states and cities
        static::deleting(function ($country) {
            if ($country->isForceDeleting()) {
                // Force delete related states and cities
                $country->states()->withTrashed()->each(function ($state) {
                    $state->cities()->withTrashed()->forceDelete();
                    $state->forceDelete();
                });
            } else {
                // Soft delete related states and cities
                $country->states()->each(function ($state) {
                    $state->cities()->delete();
                    $state->delete();
                });
            }
        });

        // Handle restoring related states and cities
        static::restored(function ($country) {
            // Restore related states
            $country->states()->withTrashed()->each(function ($state) {
                $state->restore();
                // Restore related cities
                $state->cities()->withTrashed()->restore();
            });
        });
    }

    /**
     * Get the user's image.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(DynamicContentTranslation::class, 'translationable');
    }
}
