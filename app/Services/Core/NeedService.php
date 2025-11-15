<?php

namespace App\Services\Core;

use App\Models\Need;
use Illuminate\Database\Eloquent\Builder;

class NeedService
{
    /**
     * Get base query for needs
     * This query will be used by the HasDataTable trait
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return Need::select('id', 'f_name', 'l_name', 'phone_number', 'status', 'created_at');
    }

    /**
     * Get DataTable configuration
     */
    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['f_name', 'l_name', 'phone_number'],
            'allowedSorts' => ['f_name', 'l_name', 'phone_number', 'status', 'created_at'],
            'allowedFilters' => [
                'status' => function ($query, $value) {
                    $query->where('status', $value);
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
     * Find need by ID
     */
    public function findById(int $id): ?Need
    {
        return Need::find($id);
    }

    /**
     * Find need by ID or fail
     */
    public function findByIdOrFail(int $id): Need
    {
        return Need::findOrFail($id);
    }

    /**
     * Delete a need
     */
    public function delete(Need $need): bool
    {
        return $need->delete();
    }

    /**
     * Mark need as read
     */
    public function markAsRead(Need $need): void
    {
        $need->markAsRead();
    }
}

