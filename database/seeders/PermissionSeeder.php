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
            'menu-pengaturan',
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
            'page-pengaturan-list',
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

            // ==== USER MANAGEMENT ====
            'user-create',
            'user-edit',
            'user-delete',
            'user-view',
            'user-manage-all',
            'user-manage-instansi',

            // ==== CONTENT MANAGEMENT ====
            'content-create',
            'content-edit',
            'content-delete',
            'content-view',
            'content-publish',
            'content-approve',
            'content-schedule',
            'content-withdraw',
            'content-review',
            'content-manage-all',
            'content-manage-instansi',

            // ==== DISPOSISI OPERATIONS ====
            'disposisi-create',
            'disposisi-edit',
            'disposisi-delete',
            'disposisi-view',
            'disposisi-approve',
            'disposisi-process',

            // ==== PELAYANAN OPERATIONS ====
            'pelayanan-create',
            'pelayanan-edit',
            'pelayanan-delete',
            'pelayanan-view',
            'pelayanan-approve',
            'pelayanan-process',
            'pelayanan-complete',

            // ==== ARSIP OPERATIONS ====
            'arsip-create',
            'arsip-edit',
            'arsip-delete',
            'arsip-view',
            'arsip-export',

            // ==== LAYANAN OPERATIONS ====
            'layanan-jenis-create',
            'layanan-jenis-edit',
            'layanan-jenis-delete',
            'layanan-jenis-view',
            
            'layanan-output-create',
            'layanan-output-edit',
            'layanan-output-delete',
            'layanan-output-view',

            'layanan-syarat-create',
            'layanan-syarat-edit',
            'layanan-syarat-delete',
            'layanan-syarat-view',

            // ==== REPORT OPERATIONS ====
            'report-view',
            'report-export',
            'report-analytics',

            // ==== SYSTEM MANAGEMENT ====
            'system-settings',
            'system-backup',
            'system-audit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->command->info(count($permissions) . ' permissions seeded successfully!');
    }
}