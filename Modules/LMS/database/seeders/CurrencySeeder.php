<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'usd',
                'code' => 'USD',
                'symbol' => '$',
                'exchange_rate' => null,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($currencies as $currency) {
            Currency::updateOrCreate(['name' => $currency['name']], $currency);
        }
    }
}
