<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'students',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('country_id')->nullable();
                $table->unsignedBigInteger('state_id')->nullable();
                $table->unsignedBigInteger('city_id')->nullable();
                $table->string('first_name');
                $table->string('last_name')->nullable();
                $table->string('phone');
                $table->string('profile_img')->nullable();
                $table->string('user_cv')->nullable();
                $table->string('location')->nullable();
                $table->text('about')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->integer('is_verify')->default(0);
                $table->string('address')->default(0);
                $table->integer('status')->default(1);
                $table->softDeletes();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
