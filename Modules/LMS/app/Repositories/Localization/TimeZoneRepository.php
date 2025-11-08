<?php

namespace Modules\LMS\Repositories\Localization;

use Modules\LMS\Models\Localization\TimeZone;
use Modules\LMS\Repositories\BaseRepository;

class TimeZoneRepository extends BaseRepository
{
    protected static $model = TimeZone::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:time_zones,name',

        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['_token'],
        'update' => ['_token', '_method'],
    ];

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:time_zones,name,' . $id,
        ];
        return parent::update($id, $data);
    }
}
