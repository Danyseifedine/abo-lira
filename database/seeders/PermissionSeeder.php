<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // ================================================
            // ---------------- Start Super Admin ---------------
            // ================================================
            // Dashboard permissions
            'access-super-admin-dashboard',

            // Users permissions
            'access-super-admin-users',

            // Profile permissions
            'update-super-admin-profile',
            'delete-super-admin-profile',
            'update-super-admin-password',

            // Roles permissions
            'create-super-admin-role',
            'access-super-admin-role',
            'update-super-admin-role',
            'delete-super-admin-role',

            // Permissions permissions
            'access-super-admin-permission',

            // Settings permissions
            'access-super-admin-settings',

            // Products permissions
            'access-super-admin-products',
            'access-super-admin-product-categories',
            'access-super-admin-product-qualities',
            'access-super-admin-product-colors',
            'access-super-admin-product-sizes',
            'access-super-admin-product-bundles',
            'access-super-admin-product-bundle-items',

            // Orders permissions
            'access-super-admin-orders',
            // ================================================
            // ---------------- End Super Admin ---------------
            // ================================================
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
