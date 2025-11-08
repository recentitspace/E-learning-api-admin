<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'quizzes',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('instructor_id')->nullable();
                $table->unsignedBigInteger('topic_id')->nullable();
                $table->unsignedBigInteger('topic_type_id')->nullable();
                $table->unsignedBigInteger('quiz_type_id');
                $table->string('title');
                $table->string('duration')->nullable();
                $table->integer('total_mark');
                $table->integer('pass_mark');
                $table->integer('total_retake')->nullable();
                $table->text('instruction')->nullable();
                $table->integer('is_random_question')->default(0);
                $table->integer('is_certificate')->default(0);
                $table->timestamp('expire_date')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
                $table->foreign('topic_id')->references('id')->on('topics');
                $table->foreign('instructor_id')->references('id')->on('instructors');
                $table->foreign('quiz_type_id')->references('id')->on('quiz_types');
                $table->foreign('topic_type_id')->references('id')->on('topic_types');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
