<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'quiz_questions',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('quiz_id')->references('id')->on('quizzes');
                $table->foreignId('question_id')->references('id')->on('questions');
                $table->integer('mark');
                $table->string('image')->nullable();
                $table->string('video')->nullable();
                $table->integer('position')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
