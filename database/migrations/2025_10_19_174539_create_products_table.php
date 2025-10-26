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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('cascade');
            $table->foreignId('quality_id')->constrained('product_qualities')->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('slug')->unique();

            $table->integer('bought_count')->default(0);

            // discount
            $table->boolean('is_new')->default(false);

            $table->decimal('discount_price', 10, 2)->nullable()->comment('Null if has_variants is true');
            $table->date('discount_start_date')->nullable()->comment('Null if has_limited_time_discount or has_variants is true');
            $table->date('discount_end_date')->nullable()->comment('Null if has_limited_time_discount or has_variants is true');

            $table->boolean('has_limited_time_discount')->default(false)->comment('Whether the product is available for a limited date range or forever');

            $table->integer('stock_quantity')->nullable()->comment('Null if has_variants is true');
            $table->boolean('out_of_stock')->default(false)->comment('Ignored or null if has_variants is true');
            $table->boolean('has_variants')->default(false);

            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->decimal('price', 10, 2)->nullable()->comment('Null if has_variants is true');
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index('status');
            $table->index('is_new');
            $table->index('has_variants');
            $table->index('bought_count');
            $table->index(['category_id', 'status']);
            $table->index(['quality_id', 'status']);
            $table->index('discount_start_date');
            $table->index('discount_end_date');
            $table->index(['status', 'is_new']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
