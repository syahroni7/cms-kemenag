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
        // =======================
        // Assign Roles ke User
        // =======================

        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['username' => '199605222025051001'],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password123'),
            ]
        );
        $superAdmin->assignRole('super_administrator');
        $this->command->info('Super Administrator role assigned.');

        // Admin Instansi
        $adminInstansi = User::firstOrCreate(
            ['username' => '198101212009121006'],
            [
                'name' => 'Admin Instansi',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
            ]
        );
        $adminInstansi->assignRole('admin_instansi');
        $this->command->info('Admin Instansi role assigned.');

        // Redaktur/Pimpinan Redaksi
        $redaktur = User::firstOrCreate(
            ['username' => '197010051991031004'],
            [
                'name' => 'Redaktur Utama',
                'email' => 'redaktur@example.com',
                'password' => Hash::make('password123'),
            ]
        );
        $redaktur->assignRole('redaktur');
        $this->command->info('Redaktur role assigned.');

        // Editor
        $editor = User::firstOrCreate(
            ['username' => '199404032025051006'],
            [
                'name' => 'Editor Senior',
                'email' => 'editor@example.com',
                'password' => Hash::make('password123'),
            ]
        );
        $editor->assignRole('editor');
        $this->command->info('Editor role assigned.');

        // Kontributor
        $kontributor = User::firstOrCreate(
            ['username' => '199712302025051008'],
            [
                'name' => 'Kontributor A',
                'email' => 'kontributor@example.com',
                'password' => Hash::make('password123'),
            ]
        );
        $kontributor->assignRole('kontributor');
        $this->command->info('Kontributor role assigned.');

        // Viewer
        $viewer = User::firstOrCreate(
            ['username' => '199903202025051010'],
            [
                'name' => 'Viewer Only',
                'email' => 'viewer@example.com',
                'password' => Hash::make('password123'),
            ]
        );
        $viewer->assignRole('viewer');
        $this->command->info('Viewer role assigned.');

        $this->command->info('User seeding completed!');
    }
}