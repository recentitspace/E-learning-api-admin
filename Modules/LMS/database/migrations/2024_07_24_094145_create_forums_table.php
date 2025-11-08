<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'forums',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->text('description');
                $table->string('image')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};
