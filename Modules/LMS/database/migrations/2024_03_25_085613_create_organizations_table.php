<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'organizations',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('country_id')->nullable();
                $table->unsignedBigInteger('state_id')->nullable();
                $table->unsignedBigInteger('city_id')->nullable();
                $table->unsignedBigInteger('language_id')->nullable();
                $table->unsignedBigInteger('time_zone_id')->nullable();

                $table->string('name');
                $table->string('phone');

                $table->string('profile_img')->nullable();
                $table->string('cover_photo')->nullable();
                $table->string('location')->nullable();
                $table->text('about')->nullable();
                $table->text('address')->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
