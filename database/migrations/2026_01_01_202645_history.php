<?php

use Support\Vault\Database\Blueprint;
use Support\Vault\Database\Migration;
use Support\Vault\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_history', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->unsignedBigInteger('user_id');
            $table->string('description');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_history');
    }
};