<?php

namespace Modules\LMS\Repositories\Courses\Topics\Video;

use Modules\LMS\Models\Courses\Topics\Video;
use Modules\LMS\Models\Courses\TopicType;
use Modules\LMS\Repositories\BaseRepository;

class VideoRepository extends BaseRepository
{
    protected static $model = Video::class;

    protected static $modelOne = TopicType::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'chapter_id' => 'required',
            'title' => 'required',
            'duration' => 'required',
            'topic_type' => 'required',
            'video_src_type' => 'required',

        ],
        'update' => [
            'chapter_id' => 'required',
            'duration' => 'required',
            'title' => 'required',
            'topic_type' => 'required',
            'video_src_type' => 'required',

        ],
    ];

    protected static $excludedFields = [
        'save' => ['chapter_id', 'topic_type', 'video', '_token', 'chapter_id', '_method', 'course_id'],
        'update' => ['chapter_id', 'topic_type', 'video', '_token', 'chapter_id', '_method', 'course_id', 'video_id'],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        // Set initial video topic if it exists
        $videoTopic = isset($request->video_id) ? parent::first($request->video_id)['data'] : '';

        // Check for uploaded video file and set validation rules
        if ($request->hasFile('video')) {
            static::$rules['save'] = [
                'video' => 'required|file|mimes:mp4,mov,ogg,qt,flv,mkv|max:20000',
                'chapter_id' => 'required',
                'title' => 'required',
            ];

            // Upload new video, replace existing if any
            $video = parent::upload(
                $request,
                fieldname: 'video',
                file: $videoTopic?->system_video ?? '',
                folder: 'lms/courses/topics/videos'
            );

            $request->merge(['system_video' => $video]);
        }

        // Add topic type ID to the request
        $request->merge([
            'topic_type_id' => self::topicType($request->topic_type),
        ]);

        // Save or update the video data and handle topic association
        $data = isset($request->video_id)
            ? self::update($request->video_id, $request->all())
            : parent::save($request->all());

        if ($data['status'] === 'success') {
            $topicData = [
                'chapter_id' => $request->chapter_id,
                'course_id' => $request->course_id,
            ];

            isset($request->video_id)
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
     * topicType
     *
     * @param  string  $typeName
     * @return int
     */
    public static function topicType($typeName)
    {
        $topicType = static::$modelOne::where('slug', $typeName)->select('id')->first();

        return $topicType->id;
    }
}
