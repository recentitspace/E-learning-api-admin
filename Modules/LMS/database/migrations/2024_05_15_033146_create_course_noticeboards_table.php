<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_noticeboards',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('type')->nullable();
                $table->string('title');
                $table->longText('description');
                $table->integer('is_mailable')->default(0);
                $table->foreign('course_id')->references('id')->on('courses');
                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('course_noticeboards');
    }
};
