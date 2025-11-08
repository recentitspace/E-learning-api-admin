<?php

namespace Modules\LMS\Models\Theme;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\LMS\Models\Hero\Hero;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'active',
    ];
    protected $cast = [
        'data' => 'array',
    ];

    public function hero(): HasOne
    {
        return $this->hasOne(Hero::class);
    }
}
