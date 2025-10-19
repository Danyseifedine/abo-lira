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
        ]);

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'role' => 'super-admin',
            ],
            [
                'name' => 'User',
                'email' => 'user1@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User1',
                'email' => 'user2@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User2',
                'email' => 'user3@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User3',
                'email' => 'user4@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User4',
                'email' => 'user5@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User5',
                'email' => 'user6@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User6',
                'email' => 'user7@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User7',
                'email' => 'user8@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User8',
                'email' => 'user9@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User9',
                'email' => 'user10@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User10',
                'email' => 'user11@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User11',
                'email' => 'user12@user.com',
                'role' => 'user',
            ],

            [
                'name' => 'User12',
                'email' => 'user13@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User13',
                'email' => 'user14@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User14',
                'email' => 'user15@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User15',
                'email' => 'user16@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User16',
                'email' => 'user17@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User17',
                'email' => 'user18@user.com',
                'role' => 'user',
            ],
            [
                'name' => 'User18',
                'email' => 'user19@user.com',
                'role' => 'user',
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

            if (!$user->hasRole($userData['role'])) {
                $user->assignRole($userData['role']);
                if ($userData['role'] == 'super-admin') {
                    $user->assignRole('user');
                }
            }
        }
    }
}
