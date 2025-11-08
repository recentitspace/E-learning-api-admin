<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'languages',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code');
                $table->integer('status')->default(1);
                $table->integer('active')->default(0);
                $table->integer('rtl')->default(0);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
