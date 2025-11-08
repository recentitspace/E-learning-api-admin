<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'categories',
            function (Blueprint $table) {
                $table->id();
                $table->integer('parent_id')->nullable();
                $table->string('title');
                $table->string('slug');
                $table->string('image')->nullable();
                $table->integer('order')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->integer('status')->default(1);
                $table->integer('icon_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
