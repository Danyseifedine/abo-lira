<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['stock_quantity', 'out_of_stock']);
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->integer('stock_quantity')->default(0)->after('price');
            $table->boolean('out_of_stock')->default(false)->after('stock_quantity');
        });
    }
};
