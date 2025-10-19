<?php

namespace App\Services\Core;

use App\Models\ProductVariantColor;
use Illuminate\Database\Eloquent\Builder;

class ProductColorService
{
    /**
     * Get base query for product colors
     * This query will be used by the HasDataTable trait
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return ProductVariantColor::select('id', 'name_en', 'name_ar', 'code', 'status', 'created_at');
    }

    /**
     * Get DataTable configuration
     */
    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['name_en', 'name_ar', 'code'],
            'allowedSorts' => ['name_en', 'name_ar', 'code', 'created_at'],
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

    /**
     * Toggle color status
     */
    public function toggleStatus(ProductVariantColor $color): bool
    {
        return $color->update(['status' => ! $color->status]);
    }

    /**
     * Find color by ID
     */
    public function findById(int $id): ?ProductVariantColor
    {
        return ProductVariantColor::find($id);
    }

    /**
     * Find color by ID or fail
     */
    public function findByIdOrFail(int $id): ProductVariantColor
    {
        return ProductVariantColor::findOrFail($id);
    }

    /**
     * Update color data
     */
    public function update(ProductVariantColor $color, array $data): bool
    {
        return $color->update($data);
    }

    /**
     * Create a new color
     */
    public function create(array $data): ProductVariantColor
    {
        return ProductVariantColor::create($data);
    }

    /**
     * Delete a color
     */
    public function delete(ProductVariantColor $color): bool
    {
        return $color->delete();
    }

    /**
     * Get all active colors
     */
    public function getActiveColors(): Builder
    {
        return ProductVariantColor::where('status', 1);
    }
}
