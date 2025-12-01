<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessType;

class AccessTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Super Administrator
        $superAdmin = AccessType::firstOrCreate(
            ['code' => 'superadmin'],
            [
                'name' => 'Super Administrator',
                'description' => 'Memiliki seluruh akses sistem',
            ]
        );
        $this->command->info('Super Administrator access type seeded.');

        // Admin Instansi
        $adminInstansi = AccessType::firstOrCreate(
            ['code' => 'admin_instansi'],
            [
                'name' => 'Admin Instansi',
                'description' => 'Mengelola modul instansi dan pengguna internal',
            ]
        );
        $this->command->info('Admin Instansi access type seeded.');

        // Redaktur Utama
        $redaktur = AccessType::firstOrCreate(
            ['code' => 'redaktur'],
            [
                'name' => 'Redaktur Utama',
                'description' => 'Mengelola editorial dan persetujuan konten',
            ]
        );
        $this->command->info('Redaktur Utama access type seeded.');

        // Editor
        $editor = AccessType::firstOrCreate(
            ['code' => 'editor'],
            [
                'name' => 'Editor',
                'description' => 'Mengedit dan meninjau konten sebelum publikasi',
            ]
        );
        $this->command->info('Editor access type seeded.');

        // Kontributor
        $kontributor = AccessType::firstOrCreate(
            ['code' => 'kontributor'],
            [
                'name' => 'Kontributor',
                'description' => 'Membuat konten dan mengirim untuk ditinjau',
            ]
        );
        $this->command->info('Kontributor access type seeded.');

        // Viewer Only
        $viewer = AccessType::firstOrCreate(
            ['code' => 'viewer'],
            [
                'name' => 'Viewer Only',
                'description' => 'Hanya dapat melihat konten, tanpa akses pengelolaan',
            ]
        );
        $this->command->info('Viewer Only access type seeded.');

        $this->command->info('Access type seeding completed!');
    }
}
