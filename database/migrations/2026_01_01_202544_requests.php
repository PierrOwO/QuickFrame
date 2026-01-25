<?php

use Support\Vault\Database\Blueprint;
use Support\Vault\Database\Migration;
use Support\Vault\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('action_requests', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->enum('type', ['password_reset', 'email_verification', 'data_update', 'account_activation', 'custom_action']);
            $table->string('token_hash')->nullable();
            $table->string('email')->nullable(); 
            $table->json('payload')->nullable(); 
            $table->boolean('used')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_requests');

    }
};