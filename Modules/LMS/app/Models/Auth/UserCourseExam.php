<?php

namespace Modules\LMS\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\Courses\Topics\Assignment;
use Modules\LMS\Models\Courses\Topics\AssignmentFile;
use Modules\LMS\Models\Courses\Topics\Quiz;
use Modules\LMS\Models\User;

class UserCourseExam extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function quiz(): BelongsTo
    {

        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    public function course(): BelongsTo
    {

        return $this->belongsTo(Course::class);
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sourceFiles(): HasMany
    {
        return $this->hasMany(AssignmentFile::class, 'user_exam_id', 'id');
    }
}
