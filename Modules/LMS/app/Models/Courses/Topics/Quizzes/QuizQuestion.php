<?php

namespace Modules\LMS\Models\Courses\Topics\Quizzes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\LMS\Models\QuestionScore;
use Modules\LMS\Models\TakeAnswer;

class QuizQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function questionAnswers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function userAnswers(): HasMany
    {

        return $this->hasMany(TakeAnswer::class, 'quiz_question_id', 'id');
    }

    public function questionScore(): HasOne
    {
        return $this->hasOne(QuestionScore::class, 'question_id', 'question_id');
    }
}
