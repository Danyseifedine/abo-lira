<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            ProductCategorySeeder::class,
            ProductSizeSeeder::class,
            ProductColorSeeder::class,
            ProductQualitySeeder::class,
        ]);

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'role' => 'super-admin',
            ],
            [
                'name' => 'Owner',
                'email' => 'amin@aboulira.com',
                'role' => 'owner',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            if (! $user->hasRole($userData['role'])) {
                $user->assignRole($userData['role']);
                if ($userData['role'] == 'super-admin') {
                    $user->assignRole('user');
                }
            }
        }
    }
}
