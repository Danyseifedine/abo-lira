<?php

namespace App\Services\Portal;

use App\Http\Requests\Portal\ShopRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getProductCategoriesCached(): Collection
    {
        $locale = app()->getLocale();

        $cachedData = Cache::remember(
            "portal.product_categories_with_media_{$locale}",
            now()->addHours(24),
            function () use ($locale) {
                return ProductCategory::with('media')
                    ->withCount(['products' => function ($query) {
                        $query->active();
                    }])
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
                            'products_count' => $category->products_count ?? 0,
                        ];
                    })
                    ->toArray();
            }
        );

        // Convert arrays back to objects to maintain same return format
        return collect($cachedData)->map(fn($item) => (object) $item);
    }

    public function getRandomProductsByCategoryCached(int $categoryId, int $limit = 8, bool $includeFirstVariant = true): Collection|array
    {
        $locale = app()->getLocale();

        // Cache key includes categoryId, limit, locale, and includeFirstVariant to ensure proper cache segmentation
        $cacheKey = "portal.random_products_by_category_{$categoryId}_{$limit}_{$locale}_" . ($includeFirstVariant ? '1' : '0');

        $cachedData = Cache::remember(
            $cacheKey,
            now()->addWeek(), // Cache for 1 week
            function () use ($categoryId, $limit, $locale, $includeFirstVariant) {
                // Select all necessary relations up front to avoid N+1 queries (Eloquent eager loading)
                $products = Product::with([
                    'variants' => function ($query) {
                        $query->active()->orderBy('id')->limit(1);
                    },
                    'variants.media',
                    'category:id,name_en,name_ar',
                    'quality:id,name_en,name_ar',
                ])
                    ->where('category_id', $categoryId)
                    ->active()
                    ->inRandomOrder() // Note: Random order will be cached for the week
                    ->limit($limit)
                    ->get();

                if ($includeFirstVariant && $products->isNotEmpty()) {
                    return $products->map(function ($product) use ($locale) {
                        $firstVariant = $product->variants->first();

                        $name = $locale === 'ar'
                            ? ($product->name_ar ?? $product->name)
                            : ($product->name_en ?? $product->name);

                        $description = $locale === 'ar'
                            ? ($product->description_ar ?? $product->description)
                            : ($product->description_en ?? $product->description);

                        // Priority: Use variant price if available, otherwise use product price
                        $basePrice = $firstVariant?->price ?? $product->price;

                        // Calculate prices based on discount using the reusable method
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

                // If includeFirstVariant is false, return products as-is
                return $products->toArray();
            }
        );

        // Convert back to collection of objects to maintain same return format
        return collect($cachedData)->map(fn($item) => (object) $item);
    }

    public function getProductLessThanPriceCached(float $maxPrice, int $limit = 8): Collection|array
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

    public function getProductDetails(string $slug): ?Product
    {
        $product = Product::where('slug', $slug)
            ->with([
                'category',
                'quality',
                'variants' => function ($query) {
                    $query->active()->with(['color', 'size']);
                },
            ])
            ->active()
            ->first();

        if (!$product) {
            return null;
        }

        $productDiscount = (float) ($product->discount_price ?? 0);

        // Apply discount to each variant if product has discount
        if ($productDiscount > 0) {
            $product->variants->each(function ($variant) use ($productDiscount) {
                $discountCalculation = $this->calculateDiscount(
                    (float) $variant->price,
                    $productDiscount
                );

                // Add discounted price information to variant
                $variant->setAttribute('original_price', (float) $variant->price);
                $variant->setAttribute('price', $discountCalculation['new_price']);
                $variant->setAttribute('discount_percentage', $discountCalculation['discount_percentage']);
            });
        }

        return $product;
    }

    /**
     * Get shop products with pagination, category filtering, and price filtering.
     *
     * @return array{categories: Collection, products: LengthAwarePaginator, activeCategory: object|null, filters: array}
     */
    public function getShopProducts(ShopRequest $request): array
    {
        $categories = $this->getProductCategoriesCached();

        $categorySlug = $request->validated('category');
        $activeCategory = null;
        if ($categorySlug) {
            $activeCategory = $categories->firstWhere('slug', $categorySlug);
        }

        $filters = [
            'price_min' => $request->validated('price_min'),
            'price_max' => $request->validated('price_max'),
            'sort' => $request->validated('sort', 'latest'),
        ];

        // Remove null values
        $filters = array_filter($filters, fn($value) => $value !== null);

        $products = $this->getProductsPaginated($categorySlug, $filters, 6);

        // Append query parameters to pagination links
        $products->appends($request->query());

        return [
            'categories' => $categories,
            'products' => $products,
            'activeCategory' => $activeCategory,
            'filters' => $filters,
        ];
    }

    /**
     * Get products with pagination, category filtering, and price filtering.
     *
     * @param  int|null  $categoryId
     * @param  array  $filters  ['price_min' => float, 'price_max' => float, 'sort' => string]
     * @param  int  $perPage
     * @return LengthAwarePaginator
     */
    private function getProductsPaginated(?string $categorySlug = null, array $filters = [], int $perPage = 6): LengthAwarePaginator
    {
        $query = Product::with([
            'variants' => function ($query) {
                $query->active()->orderBy('id')->limit(1);
            },
            'category',
            'quality',
        ])->active();

        // Filter by category
        if ($categorySlug) {
            $query->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        // Price filtering - need to check both product price and variant prices
        if (isset($filters['price_min']) || isset($filters['price_max'])) {
            $priceMin = $filters['price_min'] ?? 0;
            $priceMax = $filters['price_max'] ?? PHP_FLOAT_MAX;

            $query->where(function ($q) use ($priceMin, $priceMax) {
                // Products with variants (check variant prices)
                $q->whereHas('variants', function ($variantQ) use ($priceMin, $priceMax) {
                    $variantQ->active()
                        ->whereBetween('price', [$priceMin, $priceMax]);
                });
            });
        }

        // Sorting
        $sort = $filters['sort'] ?? 'latest';
        match ($sort) {
            'latest' => $query->latest('created_at'),
            'popularity' => $query->orderBy('bought_count', 'desc'),
            'newness' => $query->orderBy('is_new', 'desc')->latest('created_at'),
            'price_low' => $query->orderByRaw('COALESCE((SELECT MIN(price) FROM product_variants WHERE product_id = products.id AND status = 1), price) ASC'),
            'price_high' => $query->orderByRaw('COALESCE((SELECT MAX(price) FROM product_variants WHERE product_id = products.id AND status = 1), price) DESC'),
            default => $query->latest('created_at'),
        };

        $products = $query->paginate($perPage);

        // Transform products to include calculated prices
        $products->getCollection()->transform(function ($product) {
            $firstVariant = $product->variants->first();

            // Priority: Use variant price if available, otherwise use product price
            $basePrice = $firstVariant?->price ?? 0;

            // Calculate prices based on discount
            $discountCalculation = $this->calculateDiscount($basePrice, $product->discount_price);
            $newPrice = $discountCalculation['new_price'];
            $discountPercentage = $discountCalculation['discount_percentage'];

            // Resolve image: prefer firstVariant->image, else product->image
            $image = $firstVariant?->image ?: $product->image;

            return (object) [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => Str::limit($product->description, 100, '...'),
                'image' => $image,
                'base_price' => $basePrice,
                'price' => $newPrice,
                'discount_percentage' => round($discountPercentage, 0),
                'is_discounted' => $product->is_discounted,
                'has_multiple_variants' => $product->has_multiple_color,
                'category' => $product->category?->name,
                'quality' => $product->quality?->name
            ];
        });

        return $products;
    }

    public function getSearchProducts(string $search, int $limit = 4): Collection
    {
        $products = Product::with([
            'variants' => function ($query) {
                $query->active();
            },
            'category',
            'quality',
        ])
            ->where(function ($query) use ($search) {
                $query->where('name_en', 'like', '%' . $search . '%')
                    ->orWhere('name_ar', 'like', '%' . $search . '%');
            })
            ->active()
            ->limit($limit)
            ->get();

        return $products->transform(function ($product) {
            $firstVariant = $product->variants->first();

            // Priority: Use variant price if available, otherwise use product price
            $basePrice = $firstVariant?->price ?? 0;

            // Calculate prices based on discount
            $discountCalculation = $this->calculateDiscount($basePrice, $product->discount_price);
            $newPrice = $discountCalculation['new_price'];
            $discountPercentage = $discountCalculation['discount_percentage'];

            // Resolve image: prefer firstVariant->image, else product->image
            $image = $firstVariant?->image ?: $product->image;

            return (object) [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => Str::limit($product->description, 100, '...'),
                'image' => $image,
                'base_price' => $basePrice,
                'price' => $newPrice,
                'discount_percentage' => round($discountPercentage, 0),
                'is_discounted' => $product->is_discounted,
                'has_multiple_variants' => $product->has_multiple_color,
                'category' => $product->category?->name,
                'quality' => $product->quality?->name
            ];
        });
    }
}
