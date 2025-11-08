<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'blogs',
            function (Blueprint $table) {
                //
                $table->integer('user_id')->nullable()->after('id');
                $table->integer('admin_id')->nullable()->after('user_id');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'blogs',
            function (Blueprint $table) {
                //
                $table->dropColumn('user_id');
                $table->dropColumn('admin_id');
            }
        );
    }
};
