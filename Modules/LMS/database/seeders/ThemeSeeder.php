<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Theme\Theme;
use Illuminate\Support\Str;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Default',
                'slug' => 'default',
                'type' => 'general',
                'uuid' => Str::uuid()->toString(),
                'active' => 1,
            ],
        ];
        foreach ($themes as $theme) {
            Theme::updateOrCreate(
                ['slug' => $theme['slug']],
                [
                    'name' => $theme['name'],
                    'slug' => $theme['slug'],
                    'type' => $theme['type'],
                    'uuid' => $theme['uuid'],
                    'active' => $theme['active'],
                ],
            );
        }
    }
}