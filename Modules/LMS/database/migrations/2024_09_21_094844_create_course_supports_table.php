<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_supports',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ticket_support_id');
                $table->unsignedBigInteger('course_id');
                $table->string('type')->nullable();
                $table->timestamps();
                $table->foreign('ticket_support_id')->references('id')->on('ticket_supports')->onDelete('cascade');
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('course_supports');
    }
};
