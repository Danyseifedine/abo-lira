<?php

namespace App\Services\Core;

use App\Models\ProductQuality;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductQualityService
{
    public function getBaseQuery(): Builder
    {
        return ProductQuality::select('id', 'name_en', 'name_ar', 'slug', 'status', 'created_at');
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
                'created_from' => function ($query, $value) {
                    $query->whereDate('created_at', '>=', $value);
                },
                'created_to' => function ($query, $value) {
                    $query->whereDate('created_at', '<=', $value);
                },
            ],
        ];
    }

    public function toggleStatus(ProductQuality $quality): bool
    {
        return $quality->update(['status' => ! $quality->status]);
    }

    public function findById(int $id): ?ProductQuality
    {
        return ProductQuality::find($id);
    }

    public function findByIdOrFail(int $id): ProductQuality
    {
        return ProductQuality::findOrFail($id);
    }

    public function update(ProductQuality $quality, array $data): bool
    {
        // Auto-generate slug from name_en if not provided
        if (! isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        return $quality->update($data);
    }

    public function create(array $data): ProductQuality
    {
        // Auto-generate slug from name_en if not provided
        if (! isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']);
        }

        return ProductQuality::create($data);
    }

    public function delete(ProductQuality $quality): bool
    {
        return $quality->delete();
    }
}
