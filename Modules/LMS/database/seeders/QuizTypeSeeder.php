<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Courses\Topics\Quizzes\QuizType;

class QuizTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizTypes = [
            [
                'name' => 'Grade',
                'slug' => 'grade',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Practices',
                'slug' => 'practices',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];
        foreach ($quizTypes as $quizType) {
            QuizType::updateOrCreate(['slug' => $quizType['slug']], $quizType);
        }
    }
}
