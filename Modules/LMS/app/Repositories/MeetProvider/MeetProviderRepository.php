<?php

namespace Modules\LMS\Repositories\MeetProvider;

use Illuminate\Support\Str;
use Modules\LMS\Models\MeetProvider\MeetProviders;
use Modules\LMS\Repositories\BaseRepository;

class MeetProviderRepository extends BaseRepository
{
    protected static $model = MeetProviders::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', '_method'],
        'update' => ['_token', '_method'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required',
        ],
        'update' => [
            'name' => 'required',
        ],
    ];

    /**
     * Create a model.
     *
     * @param  array|object  $data
     */
    public static function save($request): array
    {
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        $provider = parent::save($request->all());

        return $provider;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        return parent::update($id, $request->all());
    }

    public static function delete($id, $data = [], $options = [], $relations = []): array
    {

        $response =  static::$model::find($id);
        $response->delete();

        return [
            'status' => 'success',
        ];
    }
}
