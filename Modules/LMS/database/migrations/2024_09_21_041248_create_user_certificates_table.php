<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'user_certificates',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->integer('quiz_id')->nullable();
                $table->string('certificate_id');
                $table->string(column: 'type');
                $table->string('subject');
                $table->longText('certificate_content');
                $table->date('certificated_date');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('user_certificates');
    }
};
