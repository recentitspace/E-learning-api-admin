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
        Schema::table('course_bundles', function (Blueprint $table) {

            $table->unsignedBigInteger('creator_id')->nullable()->after('id');
            $table->integer('category_id')->after('user_id')->nullable();
            $table->integer('subcategory_id')->after('category_id')->nullable();
            $table->string('video_demo')->nullable()->after('thumbnail');
            $table->enum('video_src_type', ['upload', 'youtube', 'vimeo', 'external_link', 'local'])->after('video_demo');
            $table->longText('message_for_reviewer')->nullable()->after('details');
            $table->enum('creator_type', ['admin', 'instructor', 'org'])->nullable()->after('message_for_reviewer');
            $table->integer('is_subscribe')->default(0)->after('creator_type');
            $table->integer('is_certificate')->default(0)->after('is_subscribe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_bundles', function (Blueprint $table) {
            $table->dropColumn('creator_id');
            $table->dropColumn('category_id');
            $table->dropColumn('subcategory_id');
            $table->dropColumn('video_demo');
            $table->dropColumn('video_src_type');
            $table->dropColumn('is_subscribe');
            $table->dropColumn('is_certificate');
            $table->dropColumn('message_for_reviewer');
        });
    }
};
