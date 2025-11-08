<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'question_answers',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('answer_id');
                $table->unsignedBigInteger('quiz_question_id');
                $table->integer('correct')->default(0);
                $table->timestamps();
                $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
                $table->foreign('quiz_question_id')->references('id')->on('quiz_questions')->onDelete('cascade');
            }

        );
    }

    public function down(): void
    {
        Schema::dropIfExists('question_answers');
    }
};
