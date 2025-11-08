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
        Schema::table('course_instructors', function (Blueprint $table) {
            //
            $table->decimal('percentage', 10, 2)->nullable()->after('instructor_id');
            $table->integer('is_main')->nullable()->after('percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_instructors', function (Blueprint $table) {
            //
            $table->dropColumn('percentage');
            $table->dropColumn('is_main');
        });
    }
};
