<?php

namespace Modules\LMS\Models\SupportTicket;

use Modules\LMS\Models\User;
use Modules\LMS\Models\Auth\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketReply extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function author()
    {

        return $this->belongsTo(Admin::class, 'author_id', 'id');
    }

    public function supportFiles(): MorphMany
    {
        return $this->morphMany(SupportFile::class, 'supportfileable');
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
