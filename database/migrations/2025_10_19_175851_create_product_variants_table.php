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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->foreignId('color_id')->nullable()->constrained('product_variant_colors')->onDelete('cascade');
            $table->foreignId('size_id')->nullable()->constrained('product_variant_sizes')->onDelete('cascade');

            // pricing
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();

            // stock
            $table->integer('stock_quantity');
            $table->boolean('out_of_stock')->default(false);

            // status
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index('status');
            $table->index(['product_id', 'status']);
            $table->index(['color_id', 'status']);
            $table->index(['size_id', 'status']);
            $table->index('out_of_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
