<?php

namespace App\Services\Core;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductService
{
    public function getBaseQuery(): Builder
    {
        return Product::with(['category', 'quality'])
            ->select('id', 'sku', 'category_id', 'quality_id', 'name_en', 'name_ar', 'slug', 'price', 'has_variants', 'is_new', 'status', 'created_at');
    }

    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['name_en', 'name_ar', 'sku', 'slug'],
            'allowedSorts' => ['name_en', 'name_ar', 'sku', 'price', 'created_at'],
            'allowedFilters' => [
                'status' => function ($query, $value) {
                    if ($value === 'active') {
                        $query->where('status', 1);
                    } else {
                        $query->where('status', 0);
                    }
                },
                'category_id' => function ($query, $value) {
                    $query->where('category_id', $value);
                },
                'quality_id' => function ($query, $value) {
                    $query->where('quality_id', $value);
                },
                'has_variants' => function ($query, $value) {
                    $query->where('has_variants', $value === 'yes' ? 1 : 0);
                },
                'is_new' => function ($query, $value) {
                    $query->where('is_new', $value === 'yes' ? 1 : 0);
                },
                'created_from' => function ($query, $value) {
                    $query->whereDate('created_at', '>=', $value);
                },
                'created_to' => function ($query, $value) {
                    $query->whereDate('created_at', '<=', $value);
                },
            ],
        ];
    }

    public function toggleStatus(Product $product): bool
    {
        return $product->update(['status' => ! $product->status]);
    }

    public function toggleIsNew(Product $product): bool
    {
        return $product->update(['is_new' => ! $product->is_new]);
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function findByIdOrFail(int $id): Product
    {
        return Product::with(['category', 'quality'])->findOrFail($id);
    }

    public function update(Product $product, array $data): bool
    {
        // Auto-generate slug from name_en if not provided
        if (! isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        // If has_variants is true, set price to null
        if (isset($data['has_variants']) && $data['has_variants']) {
            $data['price'] = null;
        }

        // Keep discount fields as null for now
        $data['discount_price'] = null;
        $data['discount_start_date'] = null;
        $data['discount_end_date'] = null;
        $data['has_limited_time_discount'] = false;

        return $product->update($data);
    }

    public function create(array $data): Product
    {
        // Auto-generate slug from name_en if not provided
        if (! isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        // If has_variants is true, set price to null
        if (isset($data['has_variants']) && $data['has_variants']) {
            $data['price'] = null;
        }

        // Keep discount fields as null for now
        $data['discount_price'] = null;
        $data['discount_start_date'] = null;
        $data['discount_end_date'] = null;
        $data['has_limited_time_discount'] = false;

        return Product::create($data);
    }

    public function delete(Product $product): bool
    {
        // Delete media files
        $product->clearMediaCollection('products');

        return $product->delete();
    }

    /**
     * Create a complex product with variants
     */
    public function createWithVariants(array $data, array $variants): Product
    {
        // Auto-generate slug from name_en if not provided
        if (! isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        // Set has_variants to true
        $data['has_variants'] = true;

        // Price should be null for products with variants
        $data['price'] = null;

        // Keep discount fields as null
        $data['discount_price'] = null;
        $data['discount_start_date'] = null;
        $data['discount_end_date'] = null;
        $data['has_limited_time_discount'] = false;

        // Create the product
        $product = Product::create($data);

        // Create variants in order
        $createdVariants = [];
        foreach ($variants as $variantData) {
            $createdVariants[] = $this->createVariant($product, $variantData);
        }

        // Reload product with variants
        $product->load('variants');

        return $product;
    }

    /**
     * Create a single variant for a product
     */
    public function createVariant(Product $product, array $data): \App\Models\ProductVariant
    {
        $variant = $product->variants()->create([
            'color_id' => $data['color_id'] ?? null,
            'size_id' => $data['size_id'] ?? null,
            'price' => $data['price'],
            'status' => $data['status'] ?? true,
        ]);

        return $variant;
    }
}
