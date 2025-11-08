<?php

namespace Modules\Roles\Repositories;

use Exception;
use Spatie\Permission\Models\Role;
use Modules\LMS\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    protected static $model = Role::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['permissions', '_token'],
        'update' => ['permissions', '_token', '_method'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:roles,name',
        ],
        'update' => [],
    ];

    /**
     * @param  array  $data
     */
    public static function save($data): array
    {
        $role = parent::save($data);
        if ($role['status'] == 'success' && ! empty($data['permissions'])) {
            $role['data']->givePermissionTo($data['permissions']);
        }

        return $role;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:roles,name,' . $id,
        ];
        $role = parent::update($id, $request->all());
        if ($role['status'] == 'success' && ! empty($request->permissions)) {
            $role['data']->syncPermissions($request->permissions);
        }

        return $role;
    }



    /**
     * Get models.
     *
     * @param  array  $options
     * @param  array  $relations
     */

    public static function paginate($item = 10, $relations = [], $options = [], $withTrashed = false): array
    {
        try {
            // Get Model query instance.
            $query = static::$model::query();

            $models = $query->where('guard_name', 'admin')->with($relations)->paginate($item);

            return [
                'status' => 'success',
                'data' => $models,
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }
}
