<?php

namespace Modules\LMS\Repositories\Localization;

use Modules\LMS\Models\Localization\Country;
use Modules\LMS\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    protected static $model = Country::class;
    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:countries,name',
            'code' => 'required|unique:countries,code',
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
        $country = $response['data'] ?? null;

        if($country && $response['status'] === 'success') {
            $data = self::translateData($data);
            self::translate($country, $data, locale: $data['locale'] ?? app()->getLocale());
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
        $country = $response['data'] ?? null;

        if (! $country) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        $translationData = self::translateData($data);
        $defaultLanguage = app()->getLocale();
        self::translate(model: $country,  data: $translationData, locale: $data['locale']);

        if ($data['locale'] &&  $defaultLanguage !== $data['locale']) {
            return [
                'status' => 'success',
                'data' => $country,
            ];
        }

        static::$rules['update'] = [
            'name' => 'required|unique:countries,name,' . $id,
            'code' => 'required|unique:countries,code,' . $id,
        ];

        return parent::update($id, $data);
    }

    /**
     * Change the status of the specified country.
     *
     * @param int $id
     * @return array
     */
    public function statusChange($id): array
    {
        // Retrieve the country by ID
        $response = parent::first($id);

        // Check if the city exists
        if ($response['status'] !== 'success') {
            return [
                'status' => 'error',
                'message' => 'Country not found.'
            ];
        }

        // Toggle the status of the country
        $country = $response['data'];
        $country->status = !$country->status;

        // Save the updated status
        $country->update();

        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.')
        ];
    }



    /**
     * @param  int  $id
     * @return array
     */
    public function stateGetByCountry($id, $request = null)
    {
        $locale = $request->locale ?? app()->getLocale();

        $response = parent::first(value: $id, relations: ['states.translations' => function($query) use($locale) {
            $query->where('locale', $locale);
        }]);

        $country = $response['data'] ?? [];
        $states = [];
        foreach($country->states as $state) {
            $translations = parse_translation($state, $locale);
            $state->name = $translations['name'] ?? $state->name;
            $states[] = $state;
        }

        return [
            'status' => 'success',
            'data' => $states,
        ];
    }


    public function restoreOrTrash($id)
    {
        $data = static::$model::with('states.cities')->withTrashed()->findOrFail($id);
        $data->trashed() ?  $data->restore() :  $data->delete();
        return [
            'status' => 'success',
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
