<?php

namespace Modules\LMS\Repositories\Courses;

use Modules\LMS\Models\Courses\Chapter;
use Modules\LMS\Repositories\BaseRepository;

class ChapterRepository extends BaseRepository
{
    protected static $model = Chapter::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'id'],
        'update' => ['_token', 'id'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required|string',
            'course_id' => 'required|int',
        ],
        'update' => [],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        if (isset($request->id)) {
            return self::update($request->id, $request->all());
        }

        return parent::save($request->all());
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'title' => 'required|string',
            'course_id' => 'required|int',
        ];

        return parent::update($id, $data);
    }

    public function chapterSorted($request)
    {
        if (is_array($request->itemIds)) {
            $order = 0;
            foreach ($request->itemIds as $id) {
                $order++;
                if ($chapter = static::$model::firstWhere('id', $id)) {
                    $chapter->order = $order;
                    $chapter->update();
                }
            }

            return [
                'status' => 'success',
                'data' => translate('Sorted Successfully'),
            ];
        }

        return [
            'status' => 'error',
            'data' => translate('something Wrong!'),
        ];
    }

    /**
     *  getChapterByCourse
     *
     * @param  int  $courseId
     * @return object
     */
    public static function getChapterByCourse($courseId)
    {
        return static::$model::where('course_id', $courseId)->orderBy('order')->get();
    }
}
