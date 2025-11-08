<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'chapters',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->references('id')->on('courses');
                $table->string('title');
                $table->string('order')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
