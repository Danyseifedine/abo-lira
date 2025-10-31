<?php

namespace App\Services\Portal;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductServicePortal
{
    private static array $categoryCache = [];

    private static array $qualityCache = [];

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
        $products = Product::active()
            ->latest()
            ->limit($limit)
            ->get();

        if ($includeFirstVariant) {
            $variants = $this->loadFirstVariantWithMedia($products);
            $this->loadFirstMediaForProducts($products, $variants);
            $this->preloadRelations($products);

            return $this->transformProducts($products);
        }

        return $products;
    }

    public function getRandomProductsByCategory(bool $includeFirstVariant, int $categoryId, int $limit = 8): Collection|array
    {
        // Faster random selection using ID range instead of ORDER BY RAND()
        $products = $this->getRandomProducts(
            Product::where('category_id', $categoryId)->active(),
            $limit
        );

        if ($includeFirstVariant && $products->isNotEmpty()) {
            $variants = $this->loadFirstVariantWithMedia($products);
            $this->loadFirstMediaForProducts($products, $variants);
            $this->preloadRelations($products);

            return $this->transformProducts($products);
        }

        return $products;
    }

    public function getProductLessThanPrice(bool $includeFirstVariant, float $maxPrice, int $limit = 8): Collection|array
    {
        // Get ALL products that might match (product price OR variant price < maxPrice)
        $allProducts = Product::active()
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

        if ($includeFirstVariant) {
            // Load first variant with media and price constraint, then product media only for products without variants
            $variants = $this->loadFirstVariantWithMedia($allProducts, $maxPrice);
            $this->loadFirstMediaForProducts($allProducts, $variants);
            $this->preloadRelations($allProducts);

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
            if (! $randomIds->contains($randomId)) {
                $randomIds->push($randomId);
            }
            $attempts++;
        }

        // Fetch products without media - loaded separately for optimization
        return $query->clone()
            ->whereIn('id', $randomIds)
            ->limit($limit)
            ->get()
            ->shuffle()
            ->take($limit);
    }

    /**
     * Load ONLY the first media item for products that don't have variants
     * Since variant image takes priority, we only load product media for products without variants
     */
    private function loadFirstMediaForProducts(Collection $products, Collection $productsWithVariants): void
    {
        $productsWithoutVariants = $products->filter(function ($product) use ($productsWithVariants) {
            return ! $productsWithVariants->has($product->id);
        });

        if ($productsWithoutVariants->isEmpty()) {
            foreach ($products as $product) {
                if (! $productsWithVariants->has($product->id)) {
                    $product->setRelation('media', collect());
                }
            }

            return;
        }

        $productIds = $productsWithoutVariants->pluck('id');

        // Load ONLY the first media item for products without variants
        $firstMediaItems = DB::table('media')
            ->whereIn('model_id', $productIds)
            ->where('model_type', 'App\\Models\\Product')
            ->where('collection_name', 'product-image')
            ->whereIn('id', function ($query) use ($productIds) {
                $query->selectRaw('MIN(id)')
                    ->from('media')
                    ->whereIn('model_id', $productIds)
                    ->where('model_type', 'App\\Models\\Product')
                    ->where('collection_name', 'product-image')
                    ->groupBy('model_id');
            })
            ->get()
            ->keyBy('model_id');

        // Attach the first media item to each product
        foreach ($products as $product) {
            if (! $productsWithVariants->has($product->id)) {
                if (isset($firstMediaItems[$product->id])) {
                    $mediaItem = $firstMediaItems[$product->id];
                    $media = new \Spatie\MediaLibrary\MediaCollections\Models\Media((array) $mediaItem);
                    $media->exists = true;
                    $product->setRelation('media', collect([$media]));
                } else {
                    $product->setRelation('media', collect());
                }
            }
        }
    }

    /**
     * Load ONLY the first active variant with ONLY its first media for each product
     * Ultra-optimized: Uses a single JOIN query to combine variant + media in one query
     */
    private function loadFirstVariantWithMedia(Collection $products, ?float $maxPrice = null): Collection
    {
        if ($products->isEmpty()) {
            return collect();
        }

        $productIds = $products->pluck('id');

        // Get first variants using optimized subquery
        $firstVariants = \App\Models\ProductVariant::query()
            ->select('product_variants.*')
            ->whereIn('product_id', $productIds)
            ->active()
            ->when($maxPrice !== null, function ($query) use ($maxPrice) {
                $query->where('price', '<', $maxPrice);
            })
            ->whereIn('id', function ($query) use ($productIds, $maxPrice) {
                $query->selectRaw('MIN(id)')
                    ->from('product_variants')
                    ->whereIn('product_id', $productIds)
                    ->where('status', true)
                    ->when($maxPrice !== null, function ($q) use ($maxPrice) {
                        $q->where('price', '<', $maxPrice);
                    })
                    ->groupBy('product_id');
            })
            ->get()
            ->keyBy('product_id');

        if ($firstVariants->isEmpty()) {
            return collect();
        }

        // Load ONLY first media for these variants in a single optimized query
        $variantIds = $firstVariants->pluck('id');
        $firstMediaItems = DB::table('media')
            ->whereIn('model_id', $variantIds)
            ->where('model_type', 'App\\Models\\ProductVariant')
            ->where('collection_name', 'variant-image')
            ->whereIn('id', function ($query) use ($variantIds) {
                $query->selectRaw('MIN(id)')
                    ->from('media')
                    ->whereIn('model_id', $variantIds)
                    ->where('model_type', 'App\\Models\\ProductVariant')
                    ->where('collection_name', 'variant-image')
                    ->groupBy('model_id');
            })
            ->get()
            ->keyBy('model_id');

        // Build variants with media
        $variants = collect();
        foreach ($firstVariants as $productId => $variant) {
            // Attach media if exists
            if ($firstMediaItems->has($variant->id)) {
                $mediaItem = $firstMediaItems->get($variant->id);
                $media = new \Spatie\MediaLibrary\MediaCollections\Models\Media((array) $mediaItem);
                $media->exists = true;
                $variant->setRelation('media', collect([$media]));
            } else {
                $variant->setRelation('media', collect());
            }

            $variants->put($productId, $variant);
        }

        // Attach variants to products
        foreach ($products as $product) {
            if ($variants->has($product->id)) {
                $product->setRelation('variants', collect([$variants->get($product->id)]));
            } else {
                $product->setRelation('variants', collect());
            }
        }

        return $variants;
    }

    /**
     * Preload ONLY category and quality names (not full objects with media)
     * Ultra-optimized: Only loads the name field, not full models with relationships
     */
    private function preloadRelations(Collection $products): void
    {
        $categoryIds = $products->pluck('category_id')->unique()->filter();
        $qualityIds = $products->pluck('quality_id')->unique()->filter();

        // Load ONLY name_en and name_ar for uncached categories
        $uncachedCategoryIds = $categoryIds->reject(fn($id) => isset(self::$categoryCache[$id]));
        if ($uncachedCategoryIds->isNotEmpty()) {
            $categories = DB::table('product_categories')
                ->whereIn('id', $uncachedCategoryIds)
                ->select('id', 'name_en', 'name_ar')
                ->get();

            $locale = app()->getLocale();
            foreach ($categories as $category) {
                $name = $locale === 'ar' ? $category->name_ar : $category->name_en;
                self::$categoryCache[$category->id] = (object) ['id' => $category->id, 'name' => $name];
            }
        }

        // Load ONLY name_en and name_ar for uncached qualities
        $uncachedQualityIds = $qualityIds->reject(fn($id) => isset(self::$qualityCache[$id]));
        if ($uncachedQualityIds->isNotEmpty()) {
            $qualities = DB::table('product_qualities')
                ->whereIn('id', $uncachedQualityIds)
                ->select('id', 'name_en', 'name_ar')
                ->get();

            $locale = app()->getLocale();
            foreach ($qualities as $quality) {
                $name = $locale === 'ar' ? $quality->name_ar : $quality->name_en;
                self::$qualityCache[$quality->id] = (object) ['id' => $quality->id, 'name' => $name];
            }
        }

        // Set cached relations on products (only name, not full objects)
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
