<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'forum_posts',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('forum_id');
                $table->unsignedBigInteger('sub_forum_id');
                $table->unsignedBigInteger('author_id');
                $table->string('title');
                $table->string('slug');
                $table->text('description');
                $table->timestamps();
                $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade');
                $table->foreign('sub_forum_id')->references('id')->on('sub_forums')->onDelete('cascade');
                $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
