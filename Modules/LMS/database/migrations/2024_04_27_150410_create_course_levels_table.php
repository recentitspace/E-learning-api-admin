<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_levels',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('level_id');
                $table->timestamps();
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('course_levels');
    }
};
