<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Buat role jika belum ada
        $roles = ['superadmin', 'admin', 'publisher', 'author'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Data user
        $users = [
            ['name' => 'Superadministrator', 'email' => 'superadmin@example.com', 'password' => 'superadmin123', 'role' => 'superadmin'],
            ['name' => 'Administrator',       'email' => 'admin@example.com',      'password' => 'admin123',       'role' => 'admin'],
            ['name' => 'Publisher',           'email' => 'publisher@example.com', 'password' => 'publisher123',   'role' => 'publisher'],
            ['name' => 'Author',              'email' => 'author@example.com',    'password' => 'author123',      'role' => 'author'],
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make($u['password']),
                    'email_verified_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            // Assign role menggunakan Spatie
            $user->assignRole($u['role']);
        }
    }
}
