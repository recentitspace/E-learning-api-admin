<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'icons',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('icon_provider_id')->index();
                $table->string('icon');
                $table->integer('status')->default(1);
                $table->timestamps();
                $table->foreign('icon_provider_id')->references('id')->on('icon_providers');
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('icons');
    }
};
