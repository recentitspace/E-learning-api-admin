<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            //
            $table->string('slug')->after('method_name');
            $table->string('currency')->after('slug');
            $table->float('conversation_rate')->nullable()->after('currency');
            $table->json('keys')->after('conversation_rate')->nullable();
            $table->integer('enabled_test_mode')->default(0)->after('keys');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('PaymentMethod', function (Blueprint $table) {
            //
            $table->dropColumn('slug');
            $table->dropColumn('currency');
            $table->dropColumn('conversation_rate');
            $table->dropColumn('keys');
            $table->dropColumn('enabled_test_mode');
        });
    }
};
