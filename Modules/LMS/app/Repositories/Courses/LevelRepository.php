<?php

namespace Modules\LMS\Repositories\Courses;

use Modules\LMS\Models\Courses\Level;
use Modules\LMS\Repositories\BaseRepository;

class LevelRepository extends BaseRepository
{
    protected static $model = Level::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:levels,name',
        ],
        'update' => [],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        $response = parent::save($request->all());
        $level = $response['data'] ?? null;
        if ($response['status'] === 'success' && $level) {
            $data = self::translateData($request->all());
            self::translate($level, $data, locale: $request->locale ?? app()->getLocale());
        }

        return $response;
    }

    /**
     * Update a model.
     *
     * @param  int  $id
     * @param  Request  $request
     */
    public static function update($id, $request): array
    {
        $levelResponse = parent::first(value: $id);
        $level = $levelResponse['data'] ?? null;

        if (! $level) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        static::$rules['update'] = [
            'name' => 'required|unique:levels,name,' . $id,
        ];

        $data = self::translateData($request->all());
        $defaultLanguage = app()->getLocale();
        self::translate(level: $level,  data: $data, locale: $request->locale);

        if ($request->locale &&  $defaultLanguage !== $request->locale) {
            return [
                'status' => 'success',
                'data' => $level,
            ];
        }

        return parent::update($id, $request->all());
    }

    public static function translateData(array $data)
    {
        $data = [
            'name' => $data['name'],
        ];

        return $data;
    }

    public static function translate($level, $data, $locale)
    {
        $level->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
