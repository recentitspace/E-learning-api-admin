<?php

namespace Modules\LMS\Repositories\Category;

use Illuminate\Support\Str;
use Modules\LMS\Models\Category;
use Modules\LMS\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected static $model = Category::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', '_method', 'thumbnail', 'locale'],
        'update' => ['_token', '_method', 'thumbnail', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required|unique:categories,title',
        ],
        'update' => [],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {

        if ($request->hasFile('thumbnail')) {
            static::$rules['save']['thumbnail'] = 'required|image|mimes:webp,jpeg,jpg,png,svg';
            $image = parent::upload($request, fieldname: 'thumbnail', file: '', folder: 'lms/categories');
            $request->request->add([
                'image' => $image,
            ]);
        }
        $request->request->add([
            'slug' => Str::slug($request->title),
        ]);

        $response = parent::save($request->all());
        $category = $response['data'] ?? null;

        if ($response['status'] === 'success' && $category) {
            $data = self::translateData($request->all());
            self::translate($category, $data, locale: $request->locale ?? app()->getLocale());
        }

        return $response;
    }

    /**
     * @param  int  $id
     * @param  mixed  $data
     */
    public static function update($id, $request): array
    {
        static::$rules['update']['title'] = 'required|unique:categories,title,' . $id;
        $category = parent::first($id);
        $category = $category['data'];

        if ($request->hasFile('thumbnail')) {
            static::$rules['update']['thumbnail'] =  'required|image|mimes:webp,jpeg,jpg,png,svg';
            $image = parent::upload($request, fieldname: 'thumbnail', file: $category->image, folder: 'lms/categories');
            $request->request->add([
                'image' => $image ? $image : $category->image,
            ]);
        }

        $data = self::translateData($request->all());
        self::translate($category, $data, locale: $request->locale);

        if ($request->locale &&  app('default_language') !== $request->locale) {
            return [
                'status' => 'success',
            ];
        }

        $response = parent::update($id, $request->all());

        return $response;
    }

    /**
     * @param  int  $id
     * @return int
     */
    public static function getCategoryId($id)
    {
        $category = static::$model::where('id', $id)->select('parent_id')->first();
        if ($category) {
            return $category->parent_id;
        }

        return $id;
    }

    /**
     * @param  int  $id
     * @return array
     */
    public function statusChange($id)
    {
        $category = parent::first($id);
        $category = $category['data'];
        $category->status = ! $category->status;
        $category->update();

        return [
            'status' => 'success',
            'message' => translate('Status Change Successfully'),
        ];
    }

    public static function translateData(array $data)
    {
        $data = [
            'title' => $data['title'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
        ];

        return $data;
    }

    public static function translate($category, $data, $locale)
    {
        $category->translations()->updateOrCreate(
            ['locale' => $locale],
            ['locale' => $locale, 'data' => $data]
        );
    }
}
