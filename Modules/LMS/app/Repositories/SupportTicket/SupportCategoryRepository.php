<?php

namespace Modules\LMS\Repositories\SupportTicket;

use Modules\LMS\Models\SupportTicket\SupportCategory;
use Modules\LMS\Repositories\BaseRepository;

class SupportCategoryRepository extends BaseRepository
{
    protected static $model = SupportCategory::class;

    protected static $excludedFields = [
        'save' => ['_token', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:support_categories,name',
        ],
        'update' => [],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        $response = parent::save($request->all());
        $category = $response['data'] ?? null;
        if ($response['status'] === 'success' && $category) {
            $data = self::translateData($request->all());
            self::translate($category, $data, locale: $data['locale'] ?? app()->getLocale());
        }
        return $response;
    }

    /**
     * @param  int  $id
     * @param  mixed  $request
     */
    public static function update($id, $request): array
    {
        static::$rules['update']['name'] = 'required|unique:support_categories,name,' . $id;
        $response = parent::first($id);
        $category = $response['data'];

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
     *  delete
     *
     * @param  int  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $category = SupportCategory::where('id', $id)->first();
        if ($category->delete()) {

            return [
                'status' => 'success',
            ];
        }
        return [
            'status' => 'error',
        ];
    }

    /**
     * statusChange
     *
     * @param  int  $id
     */
    public function statusChange($id): array
    {
        $forum = parent::first($id);
        $forum = $forum['data'];
        $forum->status = ! $forum->status;
        $forum->update();

        return ['status' => 'success', 'message' => translate('Status Change Successfully')];
    }


    public static function translateData(array $data)
    {
        $data = [
            'name' => $data['name'],
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
