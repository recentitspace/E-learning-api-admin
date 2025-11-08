<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'student_courses',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('student_courses');
    }
};
