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
        Schema::create('product_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('slug')->unique();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();

            // Pricing
            $table->decimal('bundle_price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable()->comment('Sum of individual product prices');

            $table->integer('stock_quantity')->nullable()->comment('Null if has_variants is true');

            $table->boolean('has_limited_time')->default(false)->comment('Whether the bundle is available for a limited date range or forever');

            // Time-limited deal
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index('status');
            $table->index('has_limited_time');
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['status', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_bundles');
    }
};
