<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hero_id')->references('id')->on('heroes')->onDelete('cascade');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->string('highlight_text')->nullable();
            $table->string('image');
            $table->text('description')->nullable();
            $table->longText('buttons')->nullable();
            $table->longText('extra')->nullable();
            $table->integer('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
