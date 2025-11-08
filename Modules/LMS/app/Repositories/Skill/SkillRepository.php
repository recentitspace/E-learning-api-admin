<?php

namespace Modules\LMS\Repositories\Skill;

use Illuminate\Support\Str;
use Modules\LMS\Models\Skill;
use Modules\LMS\Repositories\BaseRepository;

class SkillRepository extends BaseRepository
{
    protected static $model = Skill::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:skills,name',
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
            'name' => 'required|unique:skills,name,'.$id,
        ];

        return parent::update($id, $data);
    }

    /**
     *  skillSearch
     *
     * @param  mixed  $request
     * @return object
     */
    public function skillSearch($request)
    {
        return static::$model::where('name', 'like', '%'.$request->key.'%')->select('name')->get();
    }

    /**
     *  skillSave
     *
     * @param  string  $name
     * @return int
     */
    public function skillSave($name)
    {
        $skill = static::$model::firstWhere('name', $name);
        if (! $skill) {
            $skill = new static::$model;
            $skill->name = $name;
            $skill->slug = Str::slug($name);
            $skill->save();
        }

        return $skill->id;
    }
}
