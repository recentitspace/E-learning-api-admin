<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'testimonials',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('designation');
                $table->float('rating');
                $table->string('profile_image');
                $table->text('comments');
                $table->integer('status')->default(1);
                $table->softDeletes();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
