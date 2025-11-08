<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'coupons',
            function (Blueprint $table) {
                //
                $table->decimal('discount_percentage')->after('discount_type')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'coupons',
            function (Blueprint $table) {
                //
                $table->dropColumn('discount_percentage');
            }
        );
    }
};
