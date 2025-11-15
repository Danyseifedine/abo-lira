<?php

namespace App\Services\Core;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class DiscountService
{
    /**
     * Get base query for products with discounts
     * This query will be used by the HasDataTable trait
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return Product::where('is_discounted', true)
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
     */
    public function getProductsWithoutDiscounts(): Builder
    {
        return Product::where('is_discounted', false)
            ->orWhereNull('is_discounted')
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
            'is_discounted' => true,
        ];

        if ($data['has_limited_time_discount'] ?? true) {
            $updateData['discount_start_date'] = $data['discount_start_date'] ?? null;
            $updateData['discount_end_date'] = $data['discount_end_date'] ?? null;
        } else {
            $updateData['discount_start_date'] = null;
            $updateData['discount_end_date'] = null;
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

