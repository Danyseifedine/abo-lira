<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'super-admin' => [
                'access-super-admin-users',
                'access-super-admin-dashboard',
                'update-super-admin-profile',
                'delete-super-admin-profile',
                'update-super-admin-password',

                'create-super-admin-role',
                'access-super-admin-role',
                'update-super-admin-role',
                'delete-super-admin-role',

                'access-super-admin-permission',
                'access-super-admin-settings',

                'access-super-admin-products',
                'access-super-admin-product-categories',
                'access-super-admin-product-qualities',
                'access-super-admin-product-colors',
                'access-super-admin-product-sizes',
                'access-super-admin-product-bundles',
                'access-super-admin-product-bundle-items',
            ],

            'user' => [],
            'owner' => [
                'access-super-admin-dashboard',
                'update-super-admin-profile',
                'delete-super-admin-profile',
                'update-super-admin-password',

                // products
                'access-super-admin-products',
                'access-super-admin-product-categories',
                'access-super-admin-product-qualities',
                'access-super-admin-product-colors',
                'access-super-admin-product-sizes',
                'access-super-admin-product-bundles',
                'access-super-admin-product-bundle-items',
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
