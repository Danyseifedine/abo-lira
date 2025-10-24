<?php

namespace App\Services\Core;

use App\Models\ProductVariantSize;
use Illuminate\Database\Eloquent\Builder;

class ProductSizeService
{
    public function getBaseQuery(): Builder
    {
        return ProductVariantSize::select('id', 'name_en', 'name_ar', 'status', 'created_at');
    }

    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['name_en', 'name_ar'],
            'allowedSorts' => ['name_en', 'name_ar', 'status', 'created_at'],
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

    public function toggleStatus(ProductVariantSize $size): bool
    {
        return $size->update(['status' => ! $size->status]);
    }

    public function findById(int $id): ?ProductVariantSize
    {
        return ProductVariantSize::find($id);
    }

    public function findByIdOrFail(int $id): ProductVariantSize
    {
        return ProductVariantSize::findOrFail($id);
    }

    public function update(ProductVariantSize $size, array $data): bool
    {
        return $size->update($data);
    }

    public function create(array $data): ProductVariantSize
    {
        return ProductVariantSize::create($data);
    }

    public function delete(ProductVariantSize $size): bool
    {
        return $size->delete();
    }
}
