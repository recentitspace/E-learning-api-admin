<?php

namespace Modules\LMS\Models\Courses\Topics\Quizzes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\LMS\Models\TakeAnswer;

class QuestionAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    public function quizQuestion(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function takeAnswer()
    {
        return $this->hasOne(TakeAnswer::class, 'question_answer', 'id');
    }
}
