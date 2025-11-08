<?php

namespace Modules\LMS\Models\Courses\Topics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\LMS\Models\Auth\UserCourseExam;
use Modules\LMS\Models\Courses\Topic;
use Modules\LMS\Models\Courses\Topics\Quizzes\QuizQuestion;
use Modules\LMS\Models\Courses\TopicType;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function topic_type(): BelongsTo
    {
        return $this->belongsTo(TopicType::class);
    }

    public function topic(): MorphOne
    {
        return $this->morphOne(Topic::class, 'topicable');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function studentQuizzes(): HasMany
    {
        return $this->hasMany(UserCourseExam::class, 'quiz_id', 'id');
    }
}
