<?php

namespace Modules\LMS\Repositories\Page;

use Illuminate\Http\Request;
use Modules\LMS\Models\Page;
use Modules\LMS\Repositories\BaseRepository;

class PageRepository extends BaseRepository
{
    protected static $model = Page::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [],
        'update' => [
            'content' => 'required',
        ],

    ];


    /**
     * Update a model.
     *
     * @param  int  $id
     * @param  array|object  $request
     */
    public static function update($id, $request): array
    {
        $response = parent::first($id);
        $page = $response['data'];
        $data = self::translateData($request->all());
        self::translate($page, $data, locale: $request->locale);

        if ($request->locale &&  app('default_language') !== $request->locale) {
            return [
                'status' => 'success',
            ];
        }
        $response = parent::update($id, $request->all());
        return $response;
    }


    public static function translateData(array $data)
    {
        $data = [
            'title' => $data['title'],
            'content' => $data['content'],
        ];

        return $data;
    }

    public static function translate($page, $data, $locale)
    {
        $page->translations()->updateOrCreate(
            ['locale' => $locale],
            ['locale' => $locale, 'data' => $data]
        );
    }
}
