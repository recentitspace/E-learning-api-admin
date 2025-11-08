<?php

namespace Modules\LMS\Models\Purchase;

use Modules\LMS\Models\User;
use Modules\LMS\Models\SubscribeUse;
use Illuminate\Database\Eloquent\Model;
use Modules\LMS\Models\PaymentDocument;
use Modules\LMS\Models\Subscribe\Subscribe;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LMS\Enums\PurchaseType;

class Purchase extends Model
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

    public function paymentDocument(): HasOne
    {
        return $this->hasOne(PaymentDocument::class);
    }


    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

}
