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
        // Update order_histories table
        Schema::table('order_histories', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });

        // Update order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert order_histories table
        Schema::table('order_histories', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });

        // Revert order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });
    }
};
