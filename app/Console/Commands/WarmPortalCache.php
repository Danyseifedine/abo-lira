<?php

namespace App\Console\Commands;

use App\Models\ProductCategory;
use App\Services\Portal\ProductServicePortal;
use Illuminate\Console\Command;

class WarmPortalCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:warm-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up portal cache with frequently accessed data';

    /**
     * Execute the console command.
     */
    public function handle(ProductServicePortal $productService): int
    {
        $this->info('Warming portal cache...');

        // Warm categories cache
        $this->info('Caching active categories...');
        cache()->remember('portal_active_categories', 3600, function () {
            return ProductCategory::with('media')->active()->get();
        });

        // Get accessories category
        $categories = cache()->get('portal_active_categories');
        $accessoriesCategory = $categories->firstWhere('slug', 'accessories');

        if ($accessoriesCategory) {
            // Warm accessories products cache
            $this->info('Caching accessories products...');
            $cacheKey = 'portal_home_accessories_' . $accessoriesCategory->id;
            cache()->remember($cacheKey, 300, function () use ($productService, $accessoriesCategory) {
                return $productService->getRandomProductsByCategory(true, $accessoriesCategory->id, 8);
            });
        }

        // Warm products under $5 cache
        $this->info('Caching products under $5...');
        cache()->remember('portal_home_products_under_5', 300, function () use ($productService) {
            return $productService->getProductLessThanPrice(true, 5, 8);
        });

        $this->info('✓ Portal cache warmed successfully!');

        return Command::SUCCESS;
    }
}
