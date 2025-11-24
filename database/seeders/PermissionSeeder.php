<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // ==== MENU ====
            'menu-dashboard',
            'menu-main',
            'menu-disposisi',
            'menu-pelayanan',
            'menu-arsip',
            'menu-layanan',
            'menu-report',

            // ==== DASHBOARD ====
            'page-dashboard',

            // ==== MAIN (Kelola Data Utama) ====
            'page-main-permission',
            'page-main-user-data',
            'page-main-user-role',
            'page-main-unit_pengolah',

            // ==== DISPOSISI ====
            'page-disposisi-list',
            'page-disposisi-master',

            // ==== PELAYANAN ====
            'page-pelayanan-input',
            'page-pelayanan-list',

            // ==== ARSIP ====
            'page-arsip-pelayanan',

            // ==== LAYANAN ====
            'page-layanan-jenis',
            'page-layanan-output',
            'page-layanan-daftar',
            'page-layanan-syarat-master',
            'page-layanan-syarat-list',

            // ==== REPORT ====
            'page-report-layanan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->command->info(count($permissions) . ' permissions seeded successfully!');
    }
}