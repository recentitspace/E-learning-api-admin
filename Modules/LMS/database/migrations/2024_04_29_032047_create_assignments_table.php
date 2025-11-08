<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'assignments',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('topic_type_id')->references('id')->on('topic_types');
                $table->string('title');
                $table->string('duration');
                $table->text('description');
                $table->integer('total_mark')->default(0);
                $table->integer('pass_mark')->default(0);
                $table->integer('retake_number')->nullable();
                $table->timestamp('submission_date')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
