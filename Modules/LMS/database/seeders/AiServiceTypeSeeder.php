<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\ServiceType;

class AiServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $serviceTypes = [
            [
                'title' => 'Course Title',
                'length' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Course Short Description',
                'length' => 250,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Course Long Description',
                'length' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Category Title',
                'length' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Faq Title',
                'length' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Faq Answer',
                'length' => 350,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Bundle Title',
                'length' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Bundle Description',
                'length' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'About Us',
                'length' => 600,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Blog Title',
                'length' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Blog Description',
                'length' => 300,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Course Outcome Title',
                'length' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Notice Description',
                'length' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        foreach ($serviceTypes as $serviceType) {
            ServiceType::updateOrCreate(['title' => $serviceType['title']], $serviceType);
        }
    }
}
