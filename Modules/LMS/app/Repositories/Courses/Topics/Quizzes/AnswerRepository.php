<?php

namespace Modules\LMS\Repositories\Courses\Topics\Quizzes;

use Modules\LMS\Models\Courses\Topics\Quizzes\Answer;
use Modules\LMS\Repositories\BaseRepository;

class AnswerRepository extends BaseRepository
{
    protected static $model = Answer::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:answers,name',
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
            'name' => 'required|unique:answers,name,' . $id,
        ];

        return parent::update($id, $data);
    }
}
