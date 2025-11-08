<?php

namespace Modules\LMS\Repositories\IconProviders;

use Modules\LMS\Models\Icon;
use Modules\LMS\Repositories\BaseRepository;

class IconRepository extends BaseRepository
{
    protected static $model = Icon::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [

        'save' => ['_token', '_method'],
        'update' => ['_token', '_method'],
    ];

    protected static $rules = [
        'save' => [
            'icon' => 'required|unique:icons,icon',
            'icon_provider_id' => 'required',
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
            'icon' => 'required|unique:icons,icon,' . $id,
            'icon_provider_id' => 'required',
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
        $icon = $response['data'];
        // Check if language is found
        if (!$response['status']) {
            return [
                'status' => 'error',
                'message' => translate('Language not found.')
            ];
        }

        // Toggle status and save
        $icon->status = !$icon->status;
        $icon->update();
        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.')
        ];
    }
}
