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
        Schema::create('bundle_outcome', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->references('id')->on('course_bundles')->onDelete('cascade');
            $table->foreignId('outcomes_id')->references('id')->on('outcomes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_outcome');
    }
};
