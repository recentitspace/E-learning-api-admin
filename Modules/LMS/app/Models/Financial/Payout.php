<?php

namespace Modules\LMS\Models\Financial;

use Modules\LMS\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
