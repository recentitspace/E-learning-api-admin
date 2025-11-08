<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'instructors',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('country_id')->nullable();
                $table->unsignedBigInteger('state_id')->nullable();
                $table->unsignedBigInteger('city_id')->nullable();
                $table->unsignedBigInteger('language_id')->nullable();
                $table->unsignedBigInteger('time_zone_id')->nullable();
                $table->unsignedBigInteger('designation_id')->nullable();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone');
                $table->string('profile_img')->nullable();
                $table->string('cover_photo')->nullable();
                $table->string('address')->nullable();
                $table->text('about')->nullable();
                $table->integer('status')->default(1);
                $table->integer('age')->nullable();
                $table->string('gender')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
