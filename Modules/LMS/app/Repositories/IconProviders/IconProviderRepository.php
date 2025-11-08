<?php

namespace Modules\LMS\Repositories\IconProviders;

use Modules\LMS\Models\IconProvider;
use Modules\LMS\Repositories\BaseRepository;

class IconProviderRepository extends BaseRepository
{
    protected static $model = IconProvider::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', '_method'],
        'update' => ['_token', '_method'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:icon_providers,name',
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
            'name' => 'required|unique:icon_providers,name,' . $id,
        ];

        return parent::update($id, $data);
    }

    /**
     * Change the status of a icon by ID.
     *
     * @param  int  $id
     * @return array
     */
    public function statusChange($id): array
    {
        $response = parent::first($id);
        $provider = $response['data'];
        // Check if provider is found
        if (!$response['status']) {
            return [
                'status' => 'error',
                'message' => 'provider not found.'
            ];
        }

        // Toggle status and save
        $provider->status = !$provider->status;
        $provider->update();
        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.')
        ];
    }
}
