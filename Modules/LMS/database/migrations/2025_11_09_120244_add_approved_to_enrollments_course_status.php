<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to include 'approved'
        DB::statement("ALTER TABLE enrollments MODIFY COLUMN course_status ENUM('processing', 'completed', 'approved') DEFAULT 'processing'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        // First, update any 'approved' values to 'processing'
        DB::table('enrollments')
            ->where('course_status', 'approved')
            ->update(['course_status' => 'processing']);
        
        // Then modify the enum back
        DB::statement("ALTER TABLE enrollments MODIFY COLUMN course_status ENUM('processing', 'completed') DEFAULT 'processing'");
    }
};
