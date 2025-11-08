<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_settings',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->references('id')->on('courses');
                $table->integer('access_days')->nullable();
                $table->integer('sale_count_number')->nullable();
                $table->integer('seat_capacity')->nullable();
                $table->integer('has_support')->default(0);
                $table->integer('is_certificate')->default(0);
                $table->integer('is_downloadable')->default(0);
                $table->integer('has_course_forum')->default(0);
                $table->integer('has_subscription')->default(0);
                $table->integer('is_wait_list')->default(0);
                $table->integer('is_free')->default(0);
                $table->integer('is_live')->default(0);
                $table->integer('is_upcoming')->default(0);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('course_settings');
    }
};
