<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'course_prices',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->unsignedBigInteger('currency_id')->nullable();
                $table->decimal('price', 10, 2);
                $table->integer('discount_flag')->default(0);
                $table->decimal('discounted_price', 10, 2)->nullable();
                $table->timestamp('discount_period')->nullable();
                $table->timestamp('effective_date')->nullable();
                $table->timestamp('expiration_date')->nullable();
                $table->integer('auto_convert')->default(0);
                $table->timestamps();
                $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('course_prices');
    }
};
