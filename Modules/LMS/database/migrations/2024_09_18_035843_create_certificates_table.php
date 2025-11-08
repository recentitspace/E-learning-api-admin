<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'certificates',
            function (Blueprint $table) {
                $table->id();
                $table->string(column: 'title')->nullable();
                $table->longText('certificate_content')->nullable();
                $table->longText('input_content')->nullable();
                $table->enum('type', ['quiz', 'course', 'bundle'])->default('course');
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
