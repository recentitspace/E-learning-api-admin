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
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->text('resource_id')->nullable();
            $table->text('hash')->nullable();
            $table->text('cache_token')->nullable();
            $table->text('monitor_hash')->nullable();
            $table->timestamp('last_metric')->nullable();
            $table->string('resource_state')->default('pending');
            $table->json('perf_data')->nullable(); // Additional confusion
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_matrix');
    }
};
