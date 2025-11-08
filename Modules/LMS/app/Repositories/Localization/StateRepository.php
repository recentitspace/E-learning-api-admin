<?php

namespace Modules\LMS\Repositories\Localization;

use Modules\LMS\Models\Localization\State;
use Modules\LMS\Repositories\BaseRepository;

class StateRepository extends BaseRepository
{
    protected static $model = State::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:states,name',
            'country_id' => 'required',
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
        $state = $response['data'] ?? null;

        if ($state && $response['status'] === 'success') {
            $data = self::translateData($data);
            self::translate($state, $data, locale: $data['locale'] ?? app()->getLocale());
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
        $state = $response['data'] ?? null;

        if (! $state) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        $translationData = self::translateData($data);
        $defaultLanguage = app()->getLocale();
        self::translate(model: $state,  data: $translationData, locale: $data['locale']);

        if ($data['locale'] &&  $defaultLanguage !== $data['locale']) {
            return [
                'status' => 'success',
                'data' => $state,
            ];
        }

        static::$rules['update'] = [
            'name' => 'required|unique:states,name,' . $id,
            'country_id' => 'required',
        ];

        return parent::update($id, $data);
    }

    /**
     * Change the status of the specified state.
     *
     * @param int $id
     * @return array
     */
    public function statusChange($id): array
    {
        // Retrieve the state by ID
        $response = parent::first($id);

        // Check if the city exists
        if ($response['status'] !== 'success') {
            return [
                'status' => 'error',
                'message' => translate('state not found.')
            ];
        }

        // Toggle the status of the state
        $state = $response['data'];
        $state->status = !$state->status;

        // Save the updated status
        $state->update();

        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.')
        ];
    }

    /**
     * @param  int  $id
     * @return array
     */
    public function cityGetByCountry($id, $request = null)
    {
        $locale = $request->locale ?? app()->getLocale();
        $response = parent::first(value: $id, relations: ['cities.translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);

        $state = $response['data'] ?? [];
        $cities = [];
        if (isset($state?->cities) && $state?->cities->count() > 0) {
            foreach ($state?->cities as $city) {
                $translations = parse_translation($city, $locale);
                $city->name = $translations['name'] ?? $city->name;
                $cities[] = $city;
            }
        }
        return [
            'status' => 'success',
            'data' => $cities,
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
