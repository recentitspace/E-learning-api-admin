<?php

namespace Modules\LMS\Models\Localization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\LMS\Models\DynamicContentTranslation;

class State extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function cities(): HasMany
    {

        return $this->hasMany(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }


    protected static function boot()
    {
        parent::boot();

        // Handle soft deleting related and cities
        static::deleting(function ($state) {
            if ($state->isForceDeleting()) {
                // Force delete related and cities
                $state->cities()->withTrashed()->each(function ($city) {
                    $city->forceDelete();
                });
            } else {
                // Soft delete related and cities
                $state->cities()->each(function ($city) {
                    $city->delete();
                });
            }
        });

        // Handle restoring related and cities
        static::restored(function ($state) {
            // Restore related cities
            $state->cities()->withTrashed()->each(function ($city) {
                $city->restore();
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
