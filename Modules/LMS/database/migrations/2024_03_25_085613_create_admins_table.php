<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'admins',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('country_id')->nullable();
                $table->unsignedBigInteger('state_id')->nullable();
                $table->unsignedBigInteger('city_id')->nullable();
                $table->string('name');
                $table->string('email');
                $table->string('password');
                $table->string('phone');
                $table->string('profile_img')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->timestamps();

                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
