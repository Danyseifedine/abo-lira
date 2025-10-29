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
        // Remove discount_price from product_variants table
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('discount_price');
            $table->dropColumn('has_limited_time_discount');
            $table->dropColumn('discount_start_date');
            $table->dropColumn('discount_end_date');
        });

        // Add is_discounted to products table
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_discounted')->default(false)->after('discount_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add discount_price back to product_variants table
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('discount_price', 10, 2)->nullable()->after('price');
        });

        // Remove is_discounted from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_discounted');
        });
    }
};
