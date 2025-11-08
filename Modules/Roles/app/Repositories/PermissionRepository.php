<?php

namespace Modules\Roles\Repositories;

use Spatie\Permission\Models\Permission;
use Modules\LMS\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{
    protected static $model = Permission::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:permissions',
            'module' => 'required',
        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['_token'],
        'update' => ['_token', '_method'],
    ];

    public static function save($request): array
    {

        if ($request->name) {
            $request->request->add(
                [
                    'name' => $request->name . '.' . strtolower($request->module),
                    'module' => strtolower($request->module),
                ]
            );
        }


        return parent::save($request->all());
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:permissions,name,' . $id,
            'module' => 'required',
        ];

        return parent::update($id, $data);
    }
}
