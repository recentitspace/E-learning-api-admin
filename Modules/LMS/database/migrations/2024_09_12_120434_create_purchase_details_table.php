<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'purchase_details',
            function (Blueprint $table) {
                $table->id();
                $table->string('purchase_number');
                $table->foreignId('purchase_id')->reference('id')->on('purchases');
                $table->unsignedBigInteger('course_id')->nullable();
                $table->unsignedBigInteger('bundle_id')->nullable();
                $table->foreignId('user_id')->reference('id')->on('users');
                $table->decimal('price')->nullable();
                $table->json('details');
                $table->enum('type', ['enrolled', 'purchase']);
                $table->enum('purchase_type', ['bundle', 'course'])->nullable();
                $table->enum('status', ['processing', 'completed', 'pending'])->default('processing');
                $table->timestamps();
                $table->foreign('course_id')->references('id')->on('courses');
                $table->foreign('bundle_id')->references('id')->on('course_bundles');
                $table->softDeletes();
            }
        );
    }
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
