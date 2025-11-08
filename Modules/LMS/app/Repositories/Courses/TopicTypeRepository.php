<?php

namespace Modules\LMS\Repositories\Courses;

use Modules\LMS\Models\Courses\TopicType;
use Modules\LMS\Repositories\BaseRepository;

class TopicTypeRepository extends BaseRepository
{
    protected static $model = TopicType::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:topic_types,name',
        ],
        'update' => [],
    ];

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:topic_types,name,'.$id,
        ];

        return parent::update($id, $data);
    }

    /**
     * getTopicTypeId
     *
     * @param  string  $type
     * @return int
     */
    public function getTopicTypeId($type)
    {
        $topicType = static::$model::firstWhere('slug', $type);

        return $topicType->id;
    }
}
