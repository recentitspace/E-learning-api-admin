<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'ticket_replies',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('author_id')->nullable();
                $table->foreignId('ticket_support_id')->references('id')->on('ticket_supports');
                $table->text('description');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
};
