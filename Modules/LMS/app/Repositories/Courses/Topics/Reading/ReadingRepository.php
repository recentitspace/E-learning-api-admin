<?php

namespace Modules\LMS\Repositories\Courses\Topics\Reading;

use Modules\LMS\Models\Courses\Topics\Reading;
use Modules\LMS\Models\Courses\TopicType;
use Modules\LMS\Repositories\BaseRepository;

class ReadingRepository extends BaseRepository
{
    protected static $model = Reading::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'chapter_id' => 'required',
            'title' => 'required',
            'topic_type' => 'required',
            'description' => 'required',

        ],
        'update' => [
            'title' => 'required',
            'topic_type' => 'required',
            'description' => 'required',
            'chapter_id' => 'required',

        ],
    ];

    protected static $excludedFields = [
        'save' => ['chapter_id', 'topic_type', '_token', '_method', 'course_id'],
        'update' => ['chapter_id', 'topic_type', 'supplement_id', '_token', '_method', 'course_id', 'reading_id'],
    ];

    /**
     * @param  mixed  $data
     */
    public static function save($request): array
    {
        // Add topic type ID to the request
        $request->merge([
            'topic_type_id' => self::topicType($request->topic_type),
        ]);

        // Check if we are updating an existing reading or saving a new one
        if (isset($request->reading_id)) {
            return self::update($request->reading_id, $request->all());
        }

        // Save a new reading and create the associated topic
        $reading = parent::save($request->all());
        if ($reading['status'] !== 'success') {
            return $reading;
        }
        $reading['data']->topic()->create([
            'chapter_id' => $request->chapter_id,
            'course_id' => $request->course_id,
        ]);

        return $reading;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        $reading = parent::update($id, $data);
        if ($reading['status'] !== 'success') {
            return $reading;
        }
        $reading['data']->topic()->update(
            [
                'chapter_id' => $data['chapter_id'],
                'course_id' => $data['course_id'],
            ]
        );
        return $reading;
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
