<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'user_education',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('university_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('department')->nullable();
                $table->string('degree')->nullable();
                $table->string('cgpa')->nullable();
                $table->integer('duration')->nullable();
                $table->integer('passing_year')->nullable();
                $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('user_education');
    }
};
