<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_bundles',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->decimal('price');
                $table->string('thumbnail')->nullable();
                $table->text('details')->nullable();
                $table->softDeletes();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('course_bundles');
    }
};
