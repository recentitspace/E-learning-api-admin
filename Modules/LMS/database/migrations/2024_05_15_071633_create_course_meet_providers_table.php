<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_meet_providers',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->foreignId('meet_provider_id')->references('id')->on('meet_providers')->onDelete('cascade');
                $table->string('meeting_id')->nullable();
                $table->string('moderator_pw')->nullable();
                $table->date('class_schedule_date')->nullable();
                $table->text('instruction')->nullable();
                $table->string('class_schedule_time')->nullable();
                $table->softDeletes();
                $table->timestamps();
            }
        );
    }
    public function down(): void
    {
        Schema::dropIfExists('course_meet_providers');
    }
};
