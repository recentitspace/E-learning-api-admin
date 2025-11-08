<?php

namespace Modules\LMS\Models\SupportTicket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\LMS\Models\Courses\Course;

class CourseSupport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function course(): BelongsTo
    {

        return $this->belongsTo(Course::class);
    }


    public function support(): BelongsTo
    {
        return $this->belongsTo(TicketSupport::class, 'ticket_support_id', 'id');
    }
}
