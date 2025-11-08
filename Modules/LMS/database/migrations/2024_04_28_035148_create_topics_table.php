<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'topics',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('chapter_id')->nullable();
                $table->unsignedBigInteger('course_id')->nullable();
                $table->unsignedBigInteger('topicable_id');
                $table->integer('order')->nullable();
                $table->string('topicable_type');
                $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
