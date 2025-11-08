<?php

namespace Modules\LMS\Repositories;

use Modules\LMS\Models\UserType;

class UserTypeRepository extends BaseRepository
{
    protected static $model = UserType::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:user_types,name',
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
            'name' => 'required|unique:user_types,name,'.$id,
        ];

        return parent::update($id, $data);
    }
}
