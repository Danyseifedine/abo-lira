<?php

namespace App\Services\Core;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductCategoryService
{
    public function getBaseQuery(): Builder
    {
        return ProductCategory::with('parent')->select('id', 'parent_id', 'name_en', 'name_ar', 'slug', 'status', 'created_at');
    }

    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['name_en', 'name_ar', 'slug'],
            'allowedSorts' => ['name_en', 'name_ar', 'slug', 'status', 'created_at'],
            'allowedFilters' => [
                'status' => function ($query, $value) {
                    if ($value === 'active') {
                        $query->where('status', 1);
                    } else {
                        $query->where('status', 0);
                    }
                },
                'parent_id' => function ($query, $value) {
                    if ($value === 'root') {
                        $query->whereNull('parent_id');
                    } else {
                        $query->where('parent_id', $value);
                    }
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

    public function getAllCategories()
    {
        return ProductCategory::where('status', true)
            ->orderBy('name_en')
            ->get(['id', 'name_en', 'name_ar', 'parent_id']);
    }

    public function toggleStatus(ProductCategory $category): bool
    {
        return $category->update(['status' => ! $category->status]);
    }

    public function findById(int $id): ?ProductCategory
    {
        return ProductCategory::find($id);
    }

    public function findByIdOrFail(int $id): ProductCategory
    {
        return ProductCategory::findOrFail($id);
    }

    public function update(ProductCategory $category, array $data): bool
    {
        // Auto-generate slug from name_en if not provided
        if (! isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        // Prevent setting itself as parent
        if (isset($data['parent_id']) && $data['parent_id'] == $category->id) {
            $data['parent_id'] = null;
        }

        return $category->update($data);
    }

    public function create(array $data): ProductCategory
    {
        // Auto-generate slug from name_en if not provided
        if (! isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        return ProductCategory::create($data);
    }

    public function delete(ProductCategory $category): bool
    {
        return $category->delete();
    }
}
