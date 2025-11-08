<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_preview_images',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->string('image');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('course_preview_images');
    }
};
