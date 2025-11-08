<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'instructor_organizations',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('instructor_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreignId('organization_id')->references('id')->on('users')->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('instructor_organizations');
    }
};
