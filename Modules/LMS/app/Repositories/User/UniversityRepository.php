<?php

namespace Modules\LMS\Repositories\User;

use Illuminate\Support\Str;
use Modules\LMS\Models\University;
use Modules\LMS\Repositories\BaseRepository;

class UniversityRepository extends BaseRepository
{
    protected static $model = University::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:universities,name',
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
            'name' => 'required|unique:universities,name,'.$id,
        ];

        return parent::update($id, $data);
    }

    /**
     *  universitySearch
     *
     * @param  mixed  $request
     * @return object
     */
    public function universitySearch($request)
    {
        return static::$model::where('name', 'like', '%'.$request->key.'%')->get();
    }

    /**
     *  universitySave
     *
     * @param  string  $name
     * @return int
     */
    public function universitySave($name)
    {
        $university = static::$model::firstWhere('name', $name);
        if (! $university) {
            $university = new static::$model;
            $university->name = $name;
            $university->slug = Str::slug($name);
            $university->save();
        }

        return $university->id ?? null;
    }
}
