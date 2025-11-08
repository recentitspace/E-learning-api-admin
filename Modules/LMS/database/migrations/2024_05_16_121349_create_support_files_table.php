<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'support_files',
            function (Blueprint $table) {
                $table->id();
                $table->string('file');
                $table->integer('supportfileable_id');
                $table->string('supportfileable_type');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('support_files');
    }
};
