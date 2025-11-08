<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'cities',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('country_id');
                $table->unsignedBigInteger('state_id');
                $table->string('name');
                $table->integer('status')->default(1);
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
