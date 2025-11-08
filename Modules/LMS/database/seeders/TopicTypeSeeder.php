<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Courses\TopicType;

class TopicTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $topics = [
            [
                'name' => 'Video',
                'slug' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reading',
                'slug' => 'reading',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quiz',
                'slug' => 'quiz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supplement',
                'slug' => 'supplement',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Assignment',
                'slug' => 'assignment',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        foreach ($topics as $topic) {
            TopicType::updateOrCreate(['slug' => $topic['slug']], $topic);
        }
    }
}
