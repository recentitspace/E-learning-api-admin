<?php

namespace Modules\LMS\Repositories\Coupon;

use Illuminate\Support\Str;
use Modules\LMS\Models\Coupon\CouponType;
use Modules\LMS\Repositories\BaseRepository;

class CouponTypeRepository extends BaseRepository
{
    protected static $model = CouponType::class;

    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:coupon_types,name',
        ],
        'update' => [],
    ];

    /**
     * save
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);
        return parent::save($request->all());
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:coupon_types,name,' . $id,
        ];
        $request->request->add([
            'slug' => Str::slug($request->name),
        ]);

        return parent::update($id, $request->all());
    }
}
