<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'readings',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('topic_type_id')->references('id')->on('topic_types');
                $table->string('title');
                $table->text('description');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};
