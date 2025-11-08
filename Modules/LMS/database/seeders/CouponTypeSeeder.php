<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Coupon\CouponType;

class CouponTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $couponTypes = [
            [
                'name' => 'Globally',
                'slug' => 'globally',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($couponTypes as $couponType) {
            CouponType::updateOrCreate(['name' => $couponType['name']], $couponType);
        }
    }
}
