<?php


namespace Modules\LMS\Models\Courses\Bundle;

use Modules\LMS\Models\User;
use Modules\LMS\Models\Courses\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BundleCourse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    protected $table = "course_bundle_courses";

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }
    public function bundle(): BelongsTo
    {
        return $this->belongsTo(CourseBundle::class, 'course_bundle_id', 'id');
    }
}
