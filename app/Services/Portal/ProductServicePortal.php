<?php

namespace App\Services\Portal;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductServicePortal
{
    /**
     * Calculate discount prices and percentage based on base price and discount amount.
     *
     * @param  float  $basePrice  The original price (from variant or product)
     * @param  float|null  $discountAmount  The discount amount to subtract (not percentage), can be null
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

    public function getProductCategories(): Collection
    {
        $locale = app()->getLocale();

        $cachedData = Cache::remember(
            "portal.product_categories_with_media_{$locale}",
            now()->addHours(24),
            function () use ($locale) {
                return ProductCategory::with('media')
                    ->active()
                    ->get()
                    ->map(function ($category) use ($locale) {
                        return [
                            'id' => $category->id,
                            'parent_id' => $category->parent_id,
                            'name_en' => $category->name_en,
                            'name_ar' => $category->name_ar,
                            'name' => $locale === 'ar' ? $category->name_ar : $category->name_en,
                            'slug' => $category->slug,
                            'image' => $category->image, // Uses the accessor
                        ];
                    })
                    ->toArray();
            }
        );

        // Convert arrays back to objects to maintain same return format
        return collect($cachedData)->map(fn($item) => (object) $item);
    }

    /**
     * Retrieve the latest active products for the portal, optionally including their first active variant.
     *
     * If $includeFirstVariant is true, each product will have its first active variant loaded
     * (ordered by ID, limited to 1 per product, only active variants).
     *
     * @param  bool  $includeFirstVariant  Whether to eagerly load the first active variant for each product.
     * @param  int  $limit  The number of products to retrieve.
     * @return \Illuminate\Support\Collection<Product> List of recent products, each optionally with their first variant.
     */
    public function getLatestProducts(bool $includeFirstVariant = true, int $limit = 8): Collection|array
    {
        $products = Product::with([
            'variants' => function ($query) {
                $query->active()->orderBy('id');
            },
            'category',
            'quality',
        ])
            ->active()
            ->latest()
            ->limit($limit)
            ->get();

        if ($includeFirstVariant) {
            return $products->map(function ($product) {
                $firstVariant = $product->variants->first();
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
                    'has_multiple_variants' => $product->has_multiple_color,
                ];
            });
        }

        return $products;
    }

    public function getRandomProductsByCategory(bool $includeFirstVariant, int $categoryId, int $limit = 8): Collection|array
    {
        $products = Product::with([
            'variants' => function ($query) {
                $query->active()->orderBy('id');
            },
            'category',
            'quality',
        ])
            ->where('category_id', $categoryId)
            ->active()
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        if ($includeFirstVariant && $products->isNotEmpty()) {
            return $products->map(function ($product) {
                $firstVariant = $product->variants->first();
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
                    'has_multiple_variants' => $product->has_multiple_color,
                ];
            });
        }

        return $products;
    }

    public function getProductLessThanPrice(float $maxPrice, int $limit = 8): Collection|array
    {
        $locale = app()->getLocale();

        // Cache key includes maxPrice, limit, and locale to ensure proper cache segmentation
        $cacheKey = "portal.products_less_than_price_{$maxPrice}_{$limit}_{$locale}";

        $cachedData = Cache::remember(
            $cacheKey,
            now()->addWeek(), // Cache for 1 week
            function () use ($maxPrice, $limit, $locale) {
                // Select all necessary relations up front to avoid N+1 queries (Eloquent eager loading)
                $products = Product::with([
                    'variants' => function ($query) use ($maxPrice) {
                        $query->active()
                            ->where('price', '<', $maxPrice)
                            ->orderBy('id')
                            ->limit(1);
                    },
                    'variants.media',
                    'category:id,name_en,name_ar',
                    'quality:id,name_en,name_ar',
                ])
                    ->whereHas('variants', function ($query) use ($maxPrice) {
                        $query->active()->where('price', '<', $maxPrice);
                    })
                    ->active()
                    ->inRandomOrder() // Note: Random order will be cached for the week
                    ->limit($limit)
                    ->get();

                return $products->map(function ($product) use ($locale) {
                    $firstVariant = $product->variants->first();

                    $name = $locale === 'ar'
                        ? ($product->name_ar ?? $product->name)
                        : ($product->name_en ?? $product->name);

                    $description = $locale === 'ar'
                        ? ($product->description_ar ?? $product->description)
                        : ($product->description_en ?? $product->description);

                    // Prefer variant price if available
                    $basePrice = $firstVariant?->price ?? $product->price;

                    $discountCalculation = $this->calculateDiscount($basePrice, $product->discount_price);
                    $newPrice = $discountCalculation['new_price'];
                    $discountPercentage = $discountCalculation['discount_percentage'];

                    // Resolve image: prefer firstVariant->image, else product->image
                    $image = $firstVariant?->image ?: $product->image;

                    // Category and quality names, fallback to null if relation missing
                    $categoryModel = $product->category;
                    $category = null;
                    if ($categoryModel) {
                        $category = $locale === 'ar'
                            ? ($categoryModel->name_ar ?? $categoryModel->name_en)
                            : ($categoryModel->name_en ?? $categoryModel->name_ar);
                    }

                    $qualityModel = $product->quality;
                    $quality = null;
                    if ($qualityModel) {
                        $quality = $locale === 'ar'
                            ? ($qualityModel->name_ar ?? $qualityModel->name_en)
                            : ($qualityModel->name_en ?? $qualityModel->name_ar);
                    }

                    // Return as array for efficient caching (not object)
                    return [
                        'id' => $product->id,
                        'name' => $name,
                        'slug' => $product->slug,
                        'description' => Str::limit($description, 100, '...'),
                        'image' => $image,
                        'base_price' => $basePrice,
                        'price' => $newPrice,
                        'discount_percentage' => $discountPercentage,
                        'is_discounted' => $product->is_discounted,
                        'category' => $category,
                        'quality' => $quality,
                        'has_multiple_variants' => $product->has_multiple_color,
                    ];
                })->toArray();
            }
        );

        // Convert back to collection of objects to maintain same return format
        return collect($cachedData)->map(fn($item) => (object) $item);
    }
}
