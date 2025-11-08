<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'assignment_files',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('assignment_id')->nullable();
                $table->unsignedBigInteger('user_exam_id')->nullable();
                $table->string('file');
                $table->string('file_name')->nullable();
                $table->timestamps();
                $table->foreign('user_exam_id')->references('id')->on('user_course_exams')->onDelete('cascade');
                $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_files');
    }
};
