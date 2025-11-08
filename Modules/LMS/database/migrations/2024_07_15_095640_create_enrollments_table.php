<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'enrollments',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->references('id')->on('users');
                $table->unsignedBigInteger('organization_id')->nullable();
                $table->unsignedBigInteger('course_id');
                $table->string('course_title');
                $table->decimal('price', 10, 2)->nullable();
                $table->enum('status', ['free', 'paid']);
                $table->enum('course_status', ['processing', 'completed'])->default('processing');
                $table->timestamps();
                $table->foreign('organization_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
