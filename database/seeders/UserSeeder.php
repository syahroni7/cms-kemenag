<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =======================
        // Assign Roles ke User
        // =======================

        // Super Admin
        if ($user = User::where('username', '199605222025051001')->first()) {
            $user->assignRole('super_administrator');
            $this->command->info('Super Administrator role assigned to user: 199605222025051001');
        } else {
            // Jika user belum ada, buat dulu
            $superAdmin = User::create([
                'username' => '199605222025051001',
                'name' => 'Super Administrator',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password123'), // ganti dengan password yang aman
            ]);
            $superAdmin->assignRole('super_administrator');
            $this->command->info('Super Administrator user created and role assigned.');
        }

        // Admin
        if ($user = User::where('username', '198101212009121006')->first()) {
            $user->assignRole('administrator');
            $this->command->info('Administrator role assigned to user: 198101212009121006');
        } else {
            $admin = User::create([
                'username' => '198101212009121006',
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
            ]);
            $admin->assignRole('administrator');
            $this->command->info('Administrator user created and role assigned.');
        }

        // Publisher
        $publisherUsers = [
            '197010051991031004',
        ];
        $publisherCount = User::whereIn('username', $publisherUsers)
            ->get()->each(fn($user) => $user->assignRole('publisher'))->count();
        
        // Jika publisher users belum ada, buat
        if ($publisherCount === 0) {
            foreach ($publisherUsers as $username) {
                $publisher = User::create([
                    'username' => $username,
                    'name' => 'Publisher User',
                    'email' => 'publisher@example.com',
                    'password' => Hash::make('password123'),
                ]);
                $publisher->assignRole('publisher');
            }
            $this->command->info('Publisher users created and roles assigned.');
        } else {
            $this->command->info("Publisher role assigned to {$publisherCount} users");
        }

        // Author
        $authorUsers = [
            '199404032025051006',
        ];
        $authorCount = User::whereIn('username', $authorUsers)
            ->get()->each(fn($user) => $user->assignRole('author'))->count();
        
        // Jika author users belum ada, buat
        if ($authorCount === 0) {
            foreach ($authorUsers as $username) {
                $author = User::create([
                    'username' => $username,
                    'name' => 'Author User',
                    'email' => 'author@example.com',
                    'password' => Hash::make('password123'),
                ]);
                $author->assignRole('author');
            }
            $this->command->info('Author users created and roles assigned.');
        } else {
            $this->command->info("Author role assigned to {$authorCount} users");
        }

        $this->command->info('User seeding completed!');
    }
}