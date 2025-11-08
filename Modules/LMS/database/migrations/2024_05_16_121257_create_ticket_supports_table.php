<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'ticket_supports',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->unsignedBigInteger('support_category_id')->nullable();
                $table->string('ticket_code');
                $table->string('title');
                $table->integer('priority')->nullable();
                $table->text('description');
                $table->enum('type', ['course', 'platform'])->default('platform');
                $table->enum('status', ['close', 'pending', 'active'])->default('pending');
                $table->timestamps();
                $table->foreign('support_category_id')->references('id')->on('support_categories')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_supports');
    }
};
