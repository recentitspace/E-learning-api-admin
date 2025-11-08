<?php

namespace Modules\LMS\Repositories\Forum;

use Illuminate\Support\Str;
use Modules\LMS\Models\Forum\SubForum;
use Modules\LMS\Repositories\BaseRepository;

class SubForumRepository extends BaseRepository
{
    protected static $model = SubForum::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token',  'sub_forum_img'],
        'update' => ['_token', '_method', 'sub_forum_img'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:sub_forums,name',
            'forum_id' => 'required',
            'description' => 'required',
        ],
        'update' => [],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        if ($request->hasFile('sub_forum_img')) {
            $icon = parent::upload($request, fieldname: 'sub_forum_img', file: '', folder: 'lms/forums/icons');
            $request->request->add(['icon' => $icon]);
        }
        $request->request->add(['slug' => Str::slug($request->name)]);

        return parent::save($request->all());
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        // Define validation rules for updating a sub-forum.

        static::$rules['update'] = [
            'name' => 'required|unique:sub_forums,name,' . $id,
            'description' => 'required',
            'forum_id' => 'required',
        ];

        // Handle the image upload if a new file is provided.
        if ($request->hasFile('sub_forum_img')) {
            $response = parent::first($request->id);
            $subForum = $response['data'];
            $icon = parent::upload($request, fieldname: 'sub_forum_img', file: $subForum->icon ?? '', folder: 'lms/forums/icons');
            $request->request->add(['icon' => $icon ? $icon : $subForum->icon]);
        }

        $request->request->add(['slug' => Str::slug($request->name)]);
        return parent::update($id, $request->all());
    }

    /**
     *  delete
     *
     * @param  $id  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $response = parent::first($id);
        if ($response['status'] !== 'success') {
            return $response;
        }
        parent::fileDelete(folder: 'lms/forums/icons', file: $response['data']->icon);
        $response['data']->delete();

        return [
            'status' => 'success',
            'message' => translate('Delete Successfully'),
        ];
    }
}
