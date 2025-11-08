<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'active' => 1,
            ],
            [
                'name' => 'Arabic',
                'code' => 'ar',
                'rtl' => 1,
            ],
            [
                'name' => 'Spanish',
                'code' => 'es',
            ],
            [
                'name' => 'Bengali',
                'code' => 'bn',
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(['code' => $language['code']], $language);
        }
    }
}
