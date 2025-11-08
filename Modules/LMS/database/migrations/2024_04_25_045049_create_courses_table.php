<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'courses',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->unsignedBigInteger('time_zone_id')->nullable();
                $table->unsignedBigInteger('subject_id')->nullable();
                $table->unsignedBigInteger('organization_id')->nullable();
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->integer('subcategory_id')->nullable();
                $table->string('course_url')->nullable();
                $table->string('thumbnail')->nullable();
                $table->string('video_src_type')->nullable();
                $table->string('short_video')->nullable();
                $table->string('demo_url')->nullable();
                $table->text('short_description');
                $table->longText('description');
                $table->string('duration');
                $table->text('message_for_reviewer')->nullable();
                $table->date('effective_date')->nullable();
                $table->date('expiration_date')->nullable();
                $table->enum('status', ['Pending', 'Rejected', 'Approved']);
                $table->timestamps();
                $table->foreign('admin_id')->references('id')->on('admins');
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
