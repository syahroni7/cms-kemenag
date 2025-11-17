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
            KontakSeeder::class,
            MenuSeeder::class,
            SocialMediaSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
