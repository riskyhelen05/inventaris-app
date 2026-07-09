<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (['admin', 'staff', 'manager', 'user'] as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $password = Hash::make('password123');

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@gmail.com',
                'role' => 'staff',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'role' => 'manager',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'role' => 'user',
            ],
        ];

        foreach ($users as $data) {

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $password,
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}