<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'currencies',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('symbol');
                $table->string('code');
                $table->decimal('exchange_rate', 10, 2)->nullable();
                $table->integer('status')->default(1);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
