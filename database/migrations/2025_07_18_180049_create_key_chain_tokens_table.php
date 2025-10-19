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
        Schema::create('key_chain_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // e.g., 'github', 'google', 'facebook'
            $table->string('provider_id'); // Provider's user ID
            $table->text('access_token');
            $table->timestamp('expires_at')->nullable();
            $table->json('user_data')->nullable(); // Store provider user data

            // Replace user_id with morphable relationship
            $table->morphs('tokenable'); // This creates tokenable_id and tokenable_type columns

            $table->timestamps();

            // Indexes for better performance
            $table->index(['provider', 'provider_id']);

            // Use a shorter custom name for the unique constraint
            $table->unique(
                ['provider', 'provider_id', 'tokenable_type', 'tokenable_id'],
                'kct_provider_id_tokenable_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_chain_tokens');
    }
};