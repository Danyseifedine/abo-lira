<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ActivateDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discounts:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate discounts that have reached their start date';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for discounts to activate...');

        try {
            $today = now()->startOfDay();

            // Find all products with discounts that should be activated
            // - has_limited_time_discount = true
            // - is_discounted = false (not yet active)
            // - discount_start_date is not null
            // - discount_start_date <= today (start date has arrived)
            // - discount_end_date is null OR discount_end_date >= today (not expired yet)
            $productsToActivate = Product::where('has_limited_time_discount', true)
                ->where('is_discounted', false)
                ->whereNotNull('discount_start_date')
                ->whereDate('discount_start_date', '<=', $today)
                ->where(function ($query) use ($today) {
                    $query->whereNull('discount_end_date')
                        ->orWhereDate('discount_end_date', '>=', $today);
                })
                ->get();

            if ($productsToActivate->isEmpty()) {
                $this->info('No discounts to activate.');

                return self::SUCCESS;
            }

            $count = $productsToActivate->count();

            // Update all discounts to activate them
            $updated = Product::where('has_limited_time_discount', true)
                ->where('is_discounted', false)
                ->whereNotNull('discount_start_date')
                ->whereDate('discount_start_date', '<=', $today)
                ->where(function ($query) use ($today) {
                    $query->whereNull('discount_end_date')
                        ->orWhereDate('discount_end_date', '>=', $today);
                })
                ->update([
                    'is_discounted' => true,
                ]);

            $this->info("Successfully activated {$updated} discount(s).");

            // Log the product names for reference
            if ($this->option('verbose')) {
                foreach ($productsToActivate as $product) {
                    $this->line("  - {$product->name_en} (ID: {$product->id})");
                }
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to activate discounts: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}

