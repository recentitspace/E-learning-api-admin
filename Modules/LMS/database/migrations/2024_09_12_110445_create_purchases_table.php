<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'purchases',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->reference('id')->on('users');
                $table->decimal('total_amount')->nullable();
                $table->string('payment_method')->nullable();
                $table->enum('status', ['fail', 'success', 'pending', 'rejected']);
                $table->enum('type', ['enrolled', 'purchase']);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
