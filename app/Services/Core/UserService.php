<?php

namespace App\Services\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    /**
     * Get base query for users with relationships
     * This query will be used by the HasDataTable trait
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return User::select('id', 'name', 'email', 'is_active', 'email_verified_at', 'created_at');
    }

    /**
     * Get DataTable configuration
     */
    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['name', 'email'],
            'allowedSorts' => ['name', 'email', 'created_at'],
            'allowedFilters' => [
                'role' => [
                    'type' => 'relationship',
                    'relationship' => 'roles',
                    'relation_column' => 'id',
                ],
                'status' => function ($query, $value) {
                    if ($value === 'active') {
                        $query->where('is_active', 1);
                    } else {
                        $query->where('is_active', 0);
                    }
                },
                'email_verified' => function ($query, $value) {
                    if ($value === 'true') {
                        $query->whereNotNull('email_verified_at');
                    } else {
                        $query->whereNull('email_verified_at');
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
     * Toggle user active status
     */
    public function toggleStatus(User $user): bool
    {
        return $user->update(['is_active' => ! $user->is_active]);
    }

    /**
     * Find user by ID (using cache)
     */
    public function findById(int $id): ?User
    {
        return User::findCached($id);
    }

    /**
     * Find user by ID or fail (using cache)
     */
    public function findByIdOrFail(int $id): User
    {
        return User::findCachedOrFail($id);
    }

    /**
     * Update user data
     */
    public function update(User $user, array $data): bool
    {
        $user->syncRoles($data['roles']);
        $user->syncPermissions($data['permissions']);
        return $user->update($data);
    }

    /**
     * Create a new user
     */
    public function create(array $data): User
    {
        User::create($data);
        $user = User::where('email', $data['email'])->first();
        $user->assignRole($data['roles']);
        $user->givePermissionTo($data['permissions']);
        return $user;
    }

    /**
     * Delete a user
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Get all active users
     */
    public function getActiveUsers(): Builder
    {
        return User::where('is_active', 1);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $role): Builder
    {
        return User::role($role);
    }

    /**
     * Assign role to user
     */
    public function assignRole(User $user, string $role): void
    {
        $user->assignRole($role);
    }

    /**
     * Remove role from user
     */
    public function removeRole(User $user, string $role): void
    {
        $user->removeRole($role);
    }
}
