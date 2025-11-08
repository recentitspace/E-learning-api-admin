<?php


namespace Modules\LMS\Repositories\Hero;

use Modules\LMS\Models\Hero\Hero;
use Modules\LMS\Repositories\BaseRepository;

class HeroRepository extends BaseRepository
{
    protected static $model = Hero::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [

        'save' => ['_token', '_method'],
        'update' => ['_token', '_method'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required|unique:heroes,title',
            'theme_id' => 'required'
        ],
        'update' => [
            'theme_id' => 'required'
        ],
    ];

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update']['title'] = 'required|unique:heroes,title,' . $id;
        return parent::update($id, $data);
    }
}
