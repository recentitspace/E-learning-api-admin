<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'videos',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('topic_type_id')->references('id')->on('topic_types');
                $table->string('title');
                $table->string('duration');
                $table->string('video_src_type');
                $table->string('video_url')->nullable();
                $table->string('system_video')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
