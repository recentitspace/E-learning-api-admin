<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'outcomes',
            function (Blueprint $table) {
                $table->id();
                $table->text('title');
                $table->string('slug');
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('outcomes');
    }
};
