<?php

namespace Modules\LMS\Repositories\Courses;

use Modules\LMS\Models\Courses\Tag;
use Modules\LMS\Repositories\BaseRepository;

class TagRepository extends BaseRepository
{
    protected static $model = Tag::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:tags,name',
        ],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['_token', 'modal_type', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        $response = parent::save($request->all());
        $tag = $response['data'] ?? null;
        if ($response['status'] === 'success' && $tag) {
            $data = self::translateData($request->all());
            self::translate($tag, $data, locale: $request->locale ?? app()->getLocale());
        }

        return $response;
    }

    /**
     * @param  int  $id
     * @param  array|object  $data
     */
    public static function update($id, $data): array
    {
        $tagResponse = parent::first(value: $id);
        $tag = $tagResponse['data'] ?? null;

        if (! $tag) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        static::$rules['update'] = [
            'name' => 'required|unique:tags,name,' . $id,
        ];

        $translationData = self::translateData($data);
        $defaultLanguage = app()->getLocale();
        self::translate(tag: $tag,  data: $translationData, locale: $data['locale']);

        if ($data['locale'] &&  $defaultLanguage !== $data['locale']) {
            return [
                'status' => 'success',
                'data' => $tag,
            ];
        }

        return parent::update($id, $data);
    }

    public static function translateData(array $data)
    {
        $data = [
            'name' => $data['name'],
        ];

        return $data;
    }

    public static function translate($tag, $data, $locale)
    {
        $tag->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
