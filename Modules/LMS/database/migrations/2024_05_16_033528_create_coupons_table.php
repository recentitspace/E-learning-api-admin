<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'coupons',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code');
                $table->string('type');
                $table->string('discount_type');
                $table->integer('total_useable')->nullable();
                $table->decimal('minimum_order_amount', 10, 2)->nullable();
                $table->decimal('max_amount', 10, 2)->nullable();
                $table->timestamp('effective_date')->nullable();
                $table->timestamp('expiration_date')->nullable();
                $table->integer('status')->default(1);
                $table->softDeletes();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
