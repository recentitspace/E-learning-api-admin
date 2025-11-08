<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('take_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_course_exam_id')->references('id')->on('user_course_exams')->onDelete('cascade');
            $table->integer('quiz_question_id');
            $table->text('question_answer');
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('take_answers');
    }
};
