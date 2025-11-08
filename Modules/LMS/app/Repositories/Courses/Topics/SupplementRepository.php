<?php

namespace Modules\LMS\Repositories\Courses\Topics;

use Modules\LMS\Models\Courses\Topics\Supplement;
use Modules\LMS\Models\Courses\TopicType;
use Modules\LMS\Repositories\BaseRepository;

class SupplementRepository extends BaseRepository
{
    protected static $model = Supplement::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'chapter_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'topic_type' => 'required',
        ],
        'update' => [
            'chapter_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'topic_type' => 'required',
        ],
    ];

    protected static $excludedFields = [
        'save' => ['chapter_id', 'topic_type', '_token', '_method', 'course_id'],
        'update' => ['chapter_id', 'topic_type', 'supplement_id', '_token', '_method', 'course_id'],
    ];

    /**
     *  save
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {

        $request->request->add([
            'topic_type_id' => self::topicType($request->topic_type),
        ]);

        // Determine whether to update an existing record or create a new one.
        $data = isset($request->supplement_id)
            ? self::update($request->supplement_id, $request->all())
            : parent::save($request->all());

        if ($data['status'] === 'success') {
            $topicData = [
                'chapter_id' => $request->chapter_id,
                'course_id' => $request->course_id,
            ];

            isset($request->supplement_id)
                ? $data['data']->topic()->update($topicData)
                : $data['data']->topic()->create($topicData);
        }

        return $data;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        return parent::update($id, $data);
    }

    /**
     *  topicType
     *
     * @param  string  $typeName
     * @return int
     */
    public static function topicType($typeName)
    {
        $topicType = TopicType::where('slug', $typeName)->select('id')->first();

        return $topicType->id;
    }
}
