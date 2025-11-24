<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder database aplikasi.
     */
    public function run(): void
    {
        $this->call([
            // 1. Seed permissions terlebih dahulu
            PermissionSeeder::class,
            
            // 2. Seed roles setelah permissions
            RoleSeeder::class,
            
            // 3. Assign permissions ke roles (harus setelah Permission dan Role)
            RolePermissionSeeder::class,
            
            // 4. Seed data master lainnya
            AccessTypeSeeder::class,
            KontakSeeder::class,
            MenuSeeder::class,
            SocialMediaSeeder::class,
            StrukturorganisasiSeeder::class,
            
            // 5. Seed users terakhir (karena butuh roles yang sudah ada)
            UserSeeder::class, // Sekarang UserSeeder sudah include assign role
        ]);
    }
}