<?php

namespace App\Services\Portal;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class ProductServicePortal
{
    /**
     * Calculate discount prices and percentage based on base price and discount amount.
     *
     * @param float $basePrice The original price (from variant or product)
     * @param float|null $discountAmount The discount amount to subtract (not percentage), can be null
     * @return array ['new_price' => float, 'discount_percentage' => float]
     */
    public function calculateDiscount(float $basePrice, ?float $discountAmount): array
    {
        if ($discountAmount > 0 && $basePrice > 0) {
            $newPrice = $basePrice - $discountAmount;
            $discountPercentage = ($discountAmount / $basePrice) * 100;
        } else {
            $newPrice = $basePrice;
            $discountPercentage = 0;
        }

        return [
            'new_price' => $newPrice,
            'discount_percentage' => $discountPercentage,
        ];
    }

    /**
     * Retrieve the latest active products for the portal, optionally including their first active variant.
     *
     * If $includeFirstVariant is true, each product will have its first active variant loaded
     * (ordered by ID, limited to 1 per product, only active variants).
     *
     * @param bool $includeFirstVariant Whether to eagerly load the first active variant for each product.
     * @param int $limit                The number of products to retrieve.
     * @return \Illuminate\Support\Collection<Product> List of recent products, each optionally with their first variant.
     */
    public function getLatestProducts(bool $includeFirstVariant = true, int $limit = 8): Collection|array
    {
        $products = Product::with([
            'variants' => function ($query) {
                $query->active()->orderBy('id');
            },
            'category',
            'quality'
        ])
            ->active()
            ->latest()
            ->limit($limit)
            ->get();

        if ($includeFirstVariant) {
            return $products->map(function ($product) {
                $firstVariant = $product->variants->first();
                $variantCount = $product->variants->count();
                $description = app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en;

                // Priority: Use variant price if available, otherwise use product price
                $basePrice = $firstVariant?->price ?? $product->price;

                // Calculate prices based on discount using the reusable method
                $discountCalculation = $this->calculateDiscount($basePrice, $product->discount_price);
                $newPrice = $discountCalculation['new_price'];
                $discountPercentage = $discountCalculation['discount_percentage'];

                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => Str::limit($description, 100, '...'),
                    'image' => $firstVariant?->image ?? $product->image,
                    'base_price' => $basePrice,
                    'price' => $newPrice,
                    'discount_percentage' => $discountPercentage,
                    'is_discounted' => $product->is_discounted,
                    'category' => $product->category?->name ?? null,
                    'quality' => $product->quality?->name ?? null,
                    'has_multiple_variants' => $variantCount > 1,
                    'variant_count' => $variantCount,
                ];
            });
        }

        return $products;
    }

    public function getRandomProductsByCategory(bool $includeFirstVariant = true, int $categoryId, int $limit = 8): Collection|array
    {
        $products = Product::with([
            'variants' => function ($query) {
                $query->active()->orderBy('id');
            },
            'category',
            'quality'
        ])
            ->where('category_id', $categoryId)
            ->active()
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        if ($includeFirstVariant && $products->isNotEmpty()) {
            return $products->map(function ($product) {
                $firstVariant = $product->variants->first();
                $variantCount = $product->variants->count();
                $description = app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en;

                // Priority: Use variant price if available, otherwise use product price
                $basePrice = $firstVariant?->price ?? $product->price;

                // Calculate prices based on discount using the reusable method
                $discountCalculation = $this->calculateDiscount($basePrice, $product->discount_price);
                $newPrice = $discountCalculation['new_price'];
                $discountPercentage = $discountCalculation['discount_percentage'];

                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => Str::limit($description, 100, '...'),
                    'image' => $firstVariant?->image ?? $product->image,
                    'base_price' => $basePrice,
                    'price' => $newPrice,
                    'discount_percentage' => $discountPercentage,
                    'is_discounted' => $product->is_discounted,
                    'category' => $product->category?->name ?? null,
                    'quality' => $product->quality?->name ?? null,
                    'has_multiple_variants' => $variantCount > 1,
                    'variant_count' => $variantCount,
                ];
            });
        }

        return $products;
    }

    public function getProductLessThanPrice(bool $includeFirstVariant = true, float $maxPrice, int $limit = 8): Collection|array
    {
        $products = Product::with([
            'variants' => function ($query) {
                $query->active()->orderBy('id');
            },
            'category',
            'quality'
        ])
            ->active()
            ->inRandomOrder()
            ->get();

        if ($includeFirstVariant && $products->isNotEmpty()) {
            return $products->map(function ($product) {
                $firstVariant = $product->variants->first();
                $variantCount = $product->variants->count();
                $description = app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en;

                // Priority: Use variant price if available, otherwise use product price
                $basePrice = $firstVariant?->price ?? $product->price;

                // Calculate prices based on discount using the reusable method
                $discountCalculation = $this->calculateDiscount($basePrice, $product->discount_price);
                $newPrice = $discountCalculation['new_price'];
                $discountPercentage = $discountCalculation['discount_percentage'];

                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => Str::limit($description, 100, '...'),
                    'image' => $firstVariant?->image ?? $product->image,
                    'base_price' => $basePrice,
                    'price' => $newPrice,
                    'discount_percentage' => $discountPercentage,
                    'is_discounted' => $product->is_discounted,
                    'category' => $product->category?->name ?? null,
                    'quality' => $product->quality?->name ?? null,
                    'has_multiple_variants' => $variantCount > 1,
                    'variant_count' => $variantCount,
                ];
            })->filter(function ($product) use ($maxPrice) {
                // Filter based on the variant price (base_price) being less than maxPrice
                return $product->base_price < $maxPrice;
            })->take($limit);
        }

        return $products;
    }
}
