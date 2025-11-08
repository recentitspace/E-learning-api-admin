<?php

namespace Modules\LMS\Repositories\General;

use Modules\LMS\Models\Faq;
use Modules\LMS\Repositories\BaseRepository;

class FaqRepository extends BaseRepository
{
    protected static $model = Faq::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token'],
        'update' => ['_token', '_method'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required',
            'answer' => 'required',
        ],

        'update' => [
            'title' => 'required',
            'answer' => 'required',
        ],

    ];


    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $faq = static::$model::where('id', $id)->first();
        if ($faq->delete()) {

            return [
                'status' => 'success'
            ];
        }

        return [
            'status' => 'error'
        ];
    }
}
