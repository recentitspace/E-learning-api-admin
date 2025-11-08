<?php

namespace Modules\LMS\Repositories\Courses;

use Modules\LMS\Models\Outcomes;
use Modules\LMS\Repositories\BaseRepository;

class OutcomesRepository extends BaseRepository
{
    protected static $model = Outcomes::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'title' => 'required|unique:outcomes,title',
        ],
        'update' => [],
    ];

    /**
     * Update a model.
     *
     * @param  int  $id
     * @param  array|object  $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'title' => 'required|unique:outcomes,title,' . $id,
        ];

        return parent::update($id, $data);
    }

    /**
     *  outcomesSearch
     *
     * @param  mixed  $request
     * @return object
     */
    public function outcomesSearch($request)
    {
        return static::$model::where('title', 'like', '%' . $request->key . '%')->get();
    }
}
