<?php

namespace App\Services\Core;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Get base query for roles with relationships
     * This query will be used by the HasDataTable trait
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return Role::select('id', 'name', 'guard_name', 'created_at')
            ->with('permissions:id,name');
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
     * Find role by ID
     */
    public function findById(int $id): ?Role
    {
        return Role::find($id);
    }

    /**
     * Find role by ID or fail
     */
    public function findByIdOrFail(int $id): Role
    {
        return Role::findOrFail($id);
    }

    /**
     * Update role data
     */
    public function update(Role $role, array $data): bool
    {
        $role->syncPermissions($data['permissions'] ?? []);

        return $role->update(['name' => $data['name']]);
    }

    /**
     * Create a new role
     */
    public function create(array $data): Role
    {
        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    /**
     * Delete a role
     */
    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}
