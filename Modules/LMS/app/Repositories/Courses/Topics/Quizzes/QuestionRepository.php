<?php

namespace Modules\LMS\Repositories\Courses\Topics\Quizzes;

use Modules\LMS\Models\Courses\Topics\Quizzes\Question;
use Modules\LMS\Repositories\BaseRepository;

class QuestionRepository extends BaseRepository
{
    protected static $model = Question::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:questions,name',
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
            'name' => 'required|unique:questions,name,'.$id,
        ];

        return parent::update($id, $data);
    }
}
