<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'related_courses',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->references('id')->on('courses');
                $table->foreignId('related_id')->references('id')->on('courses');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('related_courses');
    }
};
