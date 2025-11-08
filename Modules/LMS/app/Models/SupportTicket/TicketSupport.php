<?php

namespace Modules\LMS\Models\SupportTicket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\LMS\Models\User;

class TicketSupport extends Model
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

    public function supportCategory(): BelongsTo
    {
        return $this->belongsTo(SupportCategory::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function courseSupport(): HasOne
    {
        return $this->hasOne(CourseSupport::class);
    }

    public function supportFiles(): MorphMany
    {
        return $this->morphMany(SupportFile::class, 'supportfileable');
    }
}
