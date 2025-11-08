<?php

namespace Modules\LMS\Repositories;

use Illuminate\Http\Request;
use Modules\LMS\Models\Language;

class LanguageRepository extends BaseRepository
{
    protected static $model = Language::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:languages,name',
            'code' => 'required|unique:languages,code',
        ],

    ];



    /**
     * Create a model.
     *
     * @param  array|object  $data
     */
    public static function save($data): array
    {
        $response = parent::save($data);
        $language = $response['data'] ?? null;
        if ($response['status'] === 'success' && $language) {
            $data = self::translateData($data);
            self::translate($language, $data, locale: $data['locale'] ?? app()->getLocale());
        }
        return $response;
    }

    /**
     * @param  int  $id
     * @param  Request  $request
     */
    public static function update($id, $request): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:languages,name,' . $id,
            'code' => 'required|unique:languages,code,' . $id,
        ];

        $response = parent::first($id);
        $language = $response['data'];
        $data = self::translateData($request->all());
        self::translate($language, $data, locale: $request->locale);

        if ($request->locale &&  app('default_language') !== $request->locale) {
            return [
                'status' => 'success',
            ];
        }
        $response = parent::update($id, $request->all());
        return $response;
    }

    /**
     * Change the default of a language by ID.
     *
     * @param  int  $id
     * @return array
     */
    public function defaultChange($id): array
    {
        $response = parent::first($id);
        $language = $response['data'];
        // Check if language is found
        if ($response['status'] !== 'success') {
            return [
                'status' => 'error',
                'message' => translate('Language not found.')
            ];
        }

        // Toggle status and save
        static::$model::query()->update(['active' => 0]);
        $language->update(['active' => 1]);

        return [
            'status' => 'success',
            'message' => translate('Status changed successfully.'),
        ];
    }



    /**
     * Change the default of a language by ID.
     *
     * @param  int  $id
     * @return array
     */
    public function rtlActive($id): array
    {
        $response = parent::first($id);
        $language = $response['data'];
        // Check if language is found
        if ($response['status'] !== 'success') {
            return [
                'status' => 'error',
                'message' => translate('Language not found.')
            ];
        }
        // Toggle status and save
        $language->rtl = !$language->rtl;
        $language->update();
        return [
            'status' => 'success',
            'message' => translate('Change successfully.'),
        ];
    }

    /**
     * Change the status of a language by ID.
     *
     * @param  int  $id
     * @return array
     */
    public function statusChange($id): array
    {
        $response = parent::first($id);
        $language = $response['data'];
        // Check if language is found
        if (!$response['status']) {
            return [
                'status' => 'error',
                'message' => translate('Language not found.')
            ];
        }

        // Toggle status and save
        $language->status = !$language->status;
        $language->update();
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
    public static function translate($language, $data, $locale)
    {
        $language->translations()->updateOrCreate(
            ['locale' => $locale],
            ['locale' => $locale, 'data' => $data]
        );
    }
}
