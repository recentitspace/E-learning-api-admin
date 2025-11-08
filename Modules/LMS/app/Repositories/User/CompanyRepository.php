<?php

namespace Modules\LMS\Repositories\User;

use Illuminate\Support\Str;
use Modules\LMS\Models\Company;
use Modules\LMS\Repositories\BaseRepository;

class CompanyRepository extends BaseRepository
{
    protected static $model = Company::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:companies,name',
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
            'name' => 'required|unique:companies,name,'.$id,
        ];

        return parent::update($id, $data);
    }

    /**
     *  companySearch
     *
     * @param  mixed  $request
     * @return object
     */
    public function companySearch($request)
    {
        return static::$model::where('name', 'like', '%'.$request->key.'%')->get();
    }

    /**
     *  companySave
     *
     * @param  string  $name
     * @return int
     */
    public function companySave($name)
    {
        $company = static::$model::firstWhere('name', $name);
        if (! $company) {
            $company = new static::$model;
            $company->name = $name;
            $company->slug = Str::slug($name);
            $company->save();
        }

        return $company->id ?? null;
    }
}
