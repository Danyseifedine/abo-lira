<?php

namespace App\Services\Core;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * Get base query for permissions with relationships
     * This query will be used by the HasDataTable trait
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return Permission::select('id', 'name', 'guard_name', 'created_at')
            ->with('roles:id,name');
    }

    /**
     * Get DataTable configuration
     */
    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['name'],
            'allowedSorts' => ['name', 'created_at'],
            'allowedFilters' => [
                'role' => [
                    'type' => 'relationship',
                    'relationship' => 'roles',
                    'relation_column' => 'id',
                ],
                'created_from' => function ($query, $value) {
                    $query->whereDate('created_at', '>=', $value);
                },
                'created_to' => function ($query, $value) {
                    $query->whereDate('created_at', '<=', $value);
                },
            ],
        ];
    }
}
