<?php

namespace App\Services\Portal;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class ProductServicePortal
{
    private static array $categoryCache = [];
    private static array $qualityCache = [];

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
            'variants.media',
            'media'
        ])
            ->active()
            ->latest()
            ->limit($limit)
            ->get();

        $this->preloadRelations($products);

        if ($includeFirstVariant) {
            return $this->transformProducts($products);
        }

        return $products;
    }

    public function getRandomProductsByCategory(bool $includeFirstVariant = true, int $categoryId, int $limit = 8): Collection|array
    {
        // Faster random selection using ID range instead of ORDER BY RAND()
        $products = $this->getRandomProducts(
            Product::where('category_id', $categoryId)->active(),
            $limit
        );

        $this->preloadRelations($products);

        if ($includeFirstVariant && $products->isNotEmpty()) {
            return $this->transformProducts($products);
        }

        return $products;
    }

    public function getProductLessThanPrice(bool $includeFirstVariant = true, float $maxPrice, int $limit = 8): Collection|array
    {
        // Get ALL products that might match (product price OR variant price < maxPrice)
        $allProducts = Product::with([
            'variants' => function ($query) use ($maxPrice) {
                $query->active()
                    ->where('price', '<', $maxPrice)
                    ->orderBy('id');
            },
            'variants.media',
            'media'
        ])
            ->active()
            ->where(function ($query) use ($maxPrice) {
                $query->where('price', '<', $maxPrice)
                    ->orWhereHas('variants', function ($q) use ($maxPrice) {
                        $q->active()->where('price', '<', $maxPrice);
                    });
            })
            ->get();

        if ($allProducts->isEmpty()) {
            return collect();
        }

        $this->preloadRelations($allProducts);

        if ($includeFirstVariant) {
            // Transform and filter to get products where actual base_price < maxPrice
            $validProducts = $this->transformProducts($allProducts)
                ->filter(function ($product) use ($maxPrice) {
                    return $product->base_price < $maxPrice;
                });

            // Randomly select $limit products from valid ones
            return $validProducts->shuffle()->take($limit)->values();
        }

        return $allProducts->shuffle()->take($limit);
    }

    /**
     * Get random products efficiently without using ORDER BY RAND()
     * Much faster on large tables (50-100x faster)
     */
    private function getRandomProducts(Builder $query, int $limit): Collection
    {
        // Get min/max ID range
        $min = (int) $query->clone()->min('id');
        $max = (int) $query->clone()->max('id');

        if ($min === 0 || $max === 0) {
            return collect();
        }

        // Generate random IDs within range
        $randomIds = collect();
        $attempts = 0;
        $maxAttempts = $limit * 5; // Try up to 5x the limit to find enough records

        while ($randomIds->count() < $limit && $attempts < $maxAttempts) {
            $randomId = rand($min, $max);
            if (!$randomIds->contains($randomId)) {
                $randomIds->push($randomId);
            }
            $attempts++;
        }

        // Fetch products with the random IDs
        return $query->clone()
            ->with([
                'variants' => function ($q) {
                    $q->active()->orderBy('id');
                },
                'variants.media',
                'media'
            ])
            ->whereIn('id', $randomIds)
            ->limit($limit)
            ->get()
            ->shuffle()
            ->take($limit);
    }

    /**
     * Preload categories and qualities with caching to avoid duplicate queries
     */
    private function preloadRelations(Collection $products): void
    {
        $categoryIds = $products->pluck('category_id')->unique()->filter();
        $qualityIds = $products->pluck('quality_id')->unique()->filter();

        // Load categories with media that aren't cached
        $uncachedCategoryIds = $categoryIds->reject(fn($id) => isset(self::$categoryCache[$id]));
        if ($uncachedCategoryIds->isNotEmpty()) {
            $categories = \App\Models\ProductCategory::with('media')
                ->whereIn('id', $uncachedCategoryIds)
                ->get();

            foreach ($categories as $category) {
                self::$categoryCache[$category->id] = $category;
            }
        }

        // Load qualities that aren't cached
        $uncachedQualityIds = $qualityIds->reject(fn($id) => isset(self::$qualityCache[$id]));
        if ($uncachedQualityIds->isNotEmpty()) {
            $qualities = \App\Models\ProductQuality::whereIn('id', $uncachedQualityIds)->get();

            foreach ($qualities as $quality) {
                self::$qualityCache[$quality->id] = $quality;
            }
        }

        // Set cached relations on products
        foreach ($products as $product) {
            if ($product->category_id && isset(self::$categoryCache[$product->category_id])) {
                $product->setRelation('category', self::$categoryCache[$product->category_id]);
            }
            if ($product->quality_id && isset(self::$qualityCache[$product->quality_id])) {
                $product->setRelation('quality', self::$qualityCache[$product->quality_id]);
            }
        }
    }

    /**
     * Transform products collection to standardized output format.
     * Reduces duplicate mapping logic across methods.
     */
    private function transformProducts(Collection $products): Collection
    {
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
}
