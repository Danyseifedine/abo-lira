<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ExpireDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discounts:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire discounts that have passed their end date';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for expired discounts...');
        $today = now()->startOfDay();
        $this->line("Today's date: {$today->format('Y-m-d')}");

        try {
            // Find all products with expired discounts
            // This includes:
            // 1. Active discounts (is_discounted = true) with end_date <= today
            // 2. Scheduled discounts (is_discounted = false) with end_date <= today
            // We check for has_limited_time_discount = true AND discount_end_date is not null
            // OR we check for any discount with an end_date that has passed
            $expiredProducts = Product::whereNotNull('discount_price')
                ->whereNotNull('discount_end_date')
                ->where(function ($query) use ($today) {
                    // Expire if end_date is today or in the past
                    $query->whereDate('discount_end_date', '<=', $today);
                })
                ->get();

            if ($expiredProducts->isEmpty()) {
                $this->info('No expired discounts found.');

                // Show debug info if verbose
                if ($this->option('verbose')) {
                    $allWithEndDate = Product::whereNotNull('discount_end_date')
                        ->whereNotNull('discount_price')
                        ->get(['id', 'name_en', 'discount_end_date', 'is_discounted', 'has_limited_time_discount']);

                    if ($allWithEndDate->isNotEmpty()) {
                        $this->line("\nAll products with discount_end_date:");
                        foreach ($allWithEndDate as $product) {
                            $endDate = $product->discount_end_date ? $product->discount_end_date->format('Y-m-d') : 'null';
                            $status = $product->is_discounted ? 'Active' : 'Scheduled';
                            $expired = $product->discount_end_date && $product->discount_end_date->lte($today) ? 'YES' : 'NO';
                            $this->line("  - ID: {$product->id}, Name: {$product->name_en}, End: {$endDate}, Status: {$status}, Expired: {$expired}");
                        }
                    }
                }

                return self::SUCCESS;
            }

            $count = $expiredProducts->count();
            $this->info("Found {$count} expired discount(s).");

            // Show which discounts will be expired
            if ($this->option('verbose')) {
                $this->line("\nDiscounts to expire:");
                foreach ($expiredProducts as $product) {
                    $endDate = $product->discount_end_date ? $product->discount_end_date->format('Y-m-d') : 'null';
                    $this->line("  - {$product->name_en} (ID: {$product->id}, End Date: {$endDate})");
                }
            }

            // Update all expired discounts in a single query for better performance
            $updated = Product::whereNotNull('discount_price')
                ->whereNotNull('discount_end_date')
                ->whereDate('discount_end_date', '<=', $today)
                ->update([
                    'discount_price' => null,
                    'discount_start_date' => null,
                    'discount_end_date' => null,
                    'has_limited_time_discount' => false,
                    'is_discounted' => false,
                ]);

            $this->info("Successfully expired {$updated} discount(s).");

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to expire discounts: ' . $e->getMessage());
            $this->error($e->getTraceAsString());

            return self::FAILURE;
        }
    }
}
