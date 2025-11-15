<?php

namespace App\Services\Core;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class DiscountService
{
    /**
     * Get base query for products with discounts
     * This query will be used by the HasDataTable trait
     * Includes both active discounts and scheduled (future) discounts
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return Product::where(function ($query) {
            // Active discounts
            $query->where('is_discounted', true)
                // Or scheduled discounts (has discount data but not yet active)
                ->orWhere(function ($q) {
                    $q->whereNotNull('discount_price')
                        ->where('is_discounted', false)
                        ->whereNotNull('discount_start_date')
                        ->whereDate('discount_start_date', '>', now()->startOfDay());
                });
        })
            ->with(['category', 'quality'])
            ->select('id', 'sku', 'name_en', 'name_ar', 'discount_price', 'discount_start_date', 'discount_end_date', 'has_limited_time_discount', 'is_discounted', 'created_at');
    }

    /**
     * Get DataTable configuration
     */
    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['sku', 'name_en', 'name_ar'],
            'allowedSorts' => ['sku', 'name_en', 'name_ar', 'discount_price', 'discount_start_date', 'discount_end_date', 'created_at'],
            'allowedFilters' => [
                'has_limited_time_discount' => function ($query, $value) {
                    $query->where('has_limited_time_discount', $value);
                },
                'discount_start_from' => function ($query, $value) {
                    $query->whereDate('discount_start_date', '>=', $value);
                },
                'discount_start_to' => function ($query, $value) {
                    $query->whereDate('discount_start_date', '<=', $value);
                },
                'discount_end_from' => function ($query, $value) {
                    $query->whereDate('discount_end_date', '>=', $value);
                },
                'discount_end_to' => function ($query, $value) {
                    $query->whereDate('discount_end_date', '<=', $value);
                },
            ],
        ];
    }

    /**
     * Get products without discounts for selection
     * Excludes products that have any discount data (active or scheduled)
     */
    public function getProductsWithoutDiscounts(): Builder
    {
        return Product::where(function ($query) {
            $query->whereNull('discount_price')
                ->orWhere('discount_price', '');
        })
            ->with(['category', 'quality'])
            ->select('id', 'sku', 'name_en', 'name_ar');
    }

    /**
     * Find product by ID
     */
    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Find product by ID or fail
     */
    public function findByIdOrFail(int $id): Product
    {
        return Product::with(['category', 'quality', 'variants.color', 'variants.size'])->findOrFail($id);
    }

    /**
     * Create discount for a product
     */
    public function createDiscount(Product $product, array $data): bool
    {
        $updateData = [
            'discount_price' => $data['discount_price'],
            'has_limited_time_discount' => $data['has_limited_time_discount'] ?? true,
        ];

        if ($data['has_limited_time_discount'] ?? true) {
            $updateData['discount_start_date'] = $data['discount_start_date'] ?? null;
            $updateData['discount_end_date'] = $data['discount_end_date'] ?? null;

            // Check if start date is in the future
            if ($updateData['discount_start_date']) {
                $startDate = is_string($updateData['discount_start_date'])
                    ? \Carbon\Carbon::parse($updateData['discount_start_date'])
                    : $updateData['discount_start_date'];

                // If start date is in the future, set is_discounted to false
                // It will be activated by the cron job when the start date arrives
                $updateData['is_discounted'] = $startDate->startOfDay()->lte(now()->startOfDay());
            } else {
                // No start date means discount is active immediately
                $updateData['is_discounted'] = true;
            }
        } else {
            $updateData['discount_start_date'] = null;
            $updateData['discount_end_date'] = null;
            // No limited time discount means it's active immediately
            $updateData['is_discounted'] = true;
        }

        return $product->update($updateData);
    }

    /**
     * Update discount for a product
     */
    public function updateDiscount(Product $product, array $data): bool
    {
        return $this->createDiscount($product, $data);
    }

    /**
     * Delete discount (remove discount from product)
     */
    public function deleteDiscount(Product $product): bool
    {
        return $product->update([
            'discount_price' => null,
            'discount_start_date' => null,
            'discount_end_date' => null,
            'has_limited_time_discount' => false,
            'is_discounted' => false,
        ]);
    }
}
