<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'blogs',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->string('thumbnail');
                $table->text('description');
                $table->integer('status')->default(1);
                $table->softDeletes();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
