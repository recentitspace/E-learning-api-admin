<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userable_id');
                $table->integer('organization_id')->nullable();
                $table->string('userable_type');
                $table->string('guard');
                $table->string('username')->nullable();
                $table->string('email');
                $table->string('password');
                $table->string('remember_me')->nullable();
                $table->integer('is_verify')->default(0);
                $table->index(['userable_id', 'userable_type']);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
