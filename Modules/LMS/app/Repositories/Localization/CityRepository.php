<?php

namespace Modules\LMS\Repositories\Localization;

use Modules\LMS\Models\Localization\City;
use Modules\LMS\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    protected static $model = City::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:cities,name',
            'country_id' => 'required',
            'state_id' => 'required',
        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['_token', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    /**
     * Create a model.
     *
     * @param  array|object  $data
     */
    public static function save($data): array
    {
        $response = parent::save($data);
        $city = $response['data'] ?? null;

        if($city && $response['status'] === 'success') {
            $data = self::translateData($data);
            self::translate($city, $data, locale: $data['locale'] ?? app()->getLocale());
        }

        return $response;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        $response = static::first($id);
        $city = $response['data'] ?? null;

        if (! $city) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        $translationData = self::translateData($data);
        $defaultLanguage = app()->getLocale();
        self::translate(model: $city,  data: $translationData, locale: $data['locale']);

        if ($data['locale'] &&  $defaultLanguage !== $data['locale']) {
            return [
                'status' => 'success',
                'data' => $city,
            ];
        }

        static::$rules['update'] = [
            'name' => 'required|unique:cities,name,' . $id,
            'country_id' => 'required',
            'state_id' => 'required',
        ];

        return parent::update($id, $data);
    }



    /**
     * Change the status of the specified city.
     *
     * @param int $id
     * @return array
     */
    public function statusChange($id): array
    {
        // Retrieve the language by ID
        $response = parent::first($id);

        // Check if the city exists
        if ($response['status'] !== 'success') {
            return [
                'status' => 'error',
                'message' => translate('Language not found.')
            ];
        }

        // Toggle the status of the city
        $city = $response['data'];
        $city->status = !$city->status;

        // Save the updated status
        $city->update();

        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.')
        ];
    }

    public static function translateData(array $data)
    {
        $data = [
            'name' => $data['name'],
        ];

        return $data;
    }

    public static function translate($model, $data, $locale)
    {
        $model->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
