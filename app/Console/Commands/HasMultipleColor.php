<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class HasMultipleColor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:has-multiple-color';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update has_multiple_color for products with more than one variant';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Updating has_multiple_color for products...');

        // Eager load variants to avoid N+1 issue
        $products = Product::withCount('variants')->get();

        foreach ($products as $product) {
            $hasMultiple = $product->variants_count > 1;
            $product->has_multiple_color = $hasMultiple;
            $product->save();
        }

        $this->info('Update complete.');

        return self::SUCCESS;
    }
}
