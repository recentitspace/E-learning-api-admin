<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\IconProvider;

class IconProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $iconProviders = [
            [
                'name' => 'Remix',
                'status' => 1
            ]
        ];

        foreach ($iconProviders as $iconProvider) {
            IconProvider::updateOrCreate(['name' => $iconProvider['name']], $iconProvider);
        }
    }
}
