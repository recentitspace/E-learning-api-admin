<?php

namespace Modules\LMS\Repositories\Courses\Topics\Quizzes;

use Modules\LMS\Models\Courses\Topics\Quizzes\QuizType;
use Modules\LMS\Repositories\BaseRepository;

class QuizTypeRepository extends BaseRepository
{
    protected static $model = QuizType::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:quiz_types,name',
        ],
        'update' => [],
    ];

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:quiz_types,name,'.$id,
        ];

        return parent::update($id, $data);
    }
}
