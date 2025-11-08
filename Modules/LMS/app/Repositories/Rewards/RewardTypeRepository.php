<?php

namespace Modules\LMS\Repositories\Rewards;

use Illuminate\Support\Str;
use Modules\LMS\Models\Rewards\RewardType;
use Modules\LMS\Repositories\BaseRepository;

class RewardTypeRepository extends BaseRepository
{
    protected static $model = RewardType::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:reward_types,name',
        ],
        'update' => [],
    ];

    public static function save($request): array
    {
        $request->request->add(
            [
                'slug' => Str::slug($request->name),
            ]
        );

        return parent::save($request->all());
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:reward_types,name,'.$id,
        ];

        $request->request->add(
            [
                'slug' => Str::slug($request->name),
            ]
        );

        return parent::update($id, $request->all());
    }
}
