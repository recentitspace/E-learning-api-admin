<?php

namespace Modules\LMS\Repositories\Review;

use Modules\LMS\Models\Courses\Review;
use Modules\LMS\Repositories\BaseRepository;

class ReviewRepository extends BaseRepository
{
    protected static $model = Review::class;
    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'course_id' => 'required',
        ],
    ];
    protected static $excludedFields = [
        'save' => ['_token', '_method'],
        'update' => ['_token', '_method'],
    ];
}
