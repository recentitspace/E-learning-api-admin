<?php

namespace Modules\LMS\Models\Courses\Topics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\LMS\Models\Courses\Topic;
use Modules\LMS\Models\Courses\TopicType;

class Supplement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function topic_type(): BelongsTo
    {
        return $this->belongsTo(TopicType::class);
    }

    public function topic(): MorphOne
    {
        return $this->morphOne(Topic::class, 'topicable');
    }
}
