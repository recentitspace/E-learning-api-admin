<?php

namespace Modules\LMS\Repositories\Blog;

use Illuminate\Http\Request;
use Modules\LMS\Models\Blog\BlogCategory;
use Modules\LMS\Repositories\BaseRepository;

class BlogCategoryRepository extends BaseRepository
{
    protected static $model = BlogCategory::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:blog_categories,name',
        ],
        'update' => [],
    ];

    /**
     * Create a model.
     *
     * @param  array|object  $data
     */
    public static function save($data): array
    {
        $response = parent::save($data);
        $blogCategory = $response['data'] ?? null;
        if ( $response['status'] === 'success' && $blogCategory ) {
            $data = self::translateData($data);
            self::translate($blogCategory, $data, locale: $data['locale'] ?? app()->getLocale());
        }

        return $response;
    }

    /**
     * @param  int  $id
     * @param array $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:blog_categories,name,' . $id,
        ];

        $blogCategoryResponse = parent::first(value: $id);
        $blogCategory = $blogCategoryResponse['data'] ?? null;

        if (! $blogCategory) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        $translateData = self::translateData($data);
        $defaultLanguage = app()->getLocale();
        self::translate(blogCategory: $blogCategory,  data: $translateData, locale: $data['locale']);

        if ($data['locale'] &&  $defaultLanguage !== $data['locale']) {
            return [
                'status' => 'success',
                'data' => $blogCategory,
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

    public static function translate($blogCategory, $data, $locale)
    {
        $blogCategory->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
