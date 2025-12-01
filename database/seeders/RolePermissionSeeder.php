<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // =======================
        // Assign Permissions to Roles
        // =======================
        $this->assignPermissionsToRoles();

        $this->command->info('Role-Permission assignment completed!');
    }

    private function assignPermissionsToRoles(): void
    {
        // =============================================
        // SUPER ADMINISTRATOR - Akses penuh ke seluruh sistem
        // =============================================
        $superAdmin = Role::findByName('super_administrator');
        $superAdmin->givePermissionTo(Permission::all());
        $this->command->info('✅ Super Administrator - All permissions assigned');

        // =============================================
        // ADMIN INSTANSI - Mengelola user di instansinya sendiri
        // =============================================
        $adminInstansi = Role::findByName('admin_instansi');
        $adminInstansi->givePermissionTo([
            // Menu Access
            'menu-dashboard', 'menu-main', 'menu-pengaturan', 'menu-pelayanan', 
            'menu-arsip', 'menu-layanan', 'menu-report',

            // Dashboard
            'page-dashboard',

            // Main - Terbatas (hanya user instansi sendiri)
            'page-main-user-data', 'page-main-unit_pengolah',

            // Disposisi
            'page-pengaturan-list', 'page-disposisi-master',

            // Pelayanan
            'page-pelayanan-input', 'page-pelayanan-list',

            // Arsip
            'page-arsip-pelayanan',

            // Layanan
            'page-layanan-jenis', 'page-layanan-output', 'page-layanan-daftar',
            'page-layanan-syarat-master', 'page-layanan-syarat-list',

            // Report
            'page-report-layanan',

            // User Management - Hanya instansi sendiri
            'user-create', 'user-edit', 'user-view', 'user-manage-instansi',

            // Content Management - Hanya instansi sendiri
            'content-create', 'content-edit', 'content-view', 'content-publish',
            'content-approve', 'content-schedule', 'content-withdraw', 'content-review',
            'content-manage-instansi',

            // Disposisi Operations
            'disposisi-create', 'disposisi-edit', 'disposisi-view', 
            'disposisi-approve', 'disposisi-process',

            // Pelayanan Operations
            'pelayanan-create', 'pelayanan-edit', 'pelayanan-view', 
            'pelayanan-approve', 'pelayanan-process', 'pelayanan-complete',

            // Arsip Operations
            'arsip-create', 'arsip-edit', 'arsip-view', 'arsip-export',

            // Layanan Operations
            'layanan-jenis-create', 'layanan-jenis-edit', 'layanan-jenis-view',
            'layanan-output-create', 'layanan-output-edit', 'layanan-output-view',
            'layanan-syarat-create', 'layanan-syarat-edit', 'layanan-syarat-view',

            // Report Operations
            'report-view', 'report-export',
        ]);
        $this->command->info('✅ Admin Instansi - Permissions assigned');

        // =============================================
        // REDAKTUR/PIMPINAN REDAKSI - Bertanggung jawab final
        // =============================================
        $redaktur = Role::findByName('redaktur');
        $redaktur->givePermissionTo([
            // Menu Access
            'menu-dashboard', 'menu-pengaturan', 'menu-pelayanan', 
            'menu-arsip', 'menu-layanan', 'menu-report',

            // Dashboard
            'page-dashboard',

            // Disposisi
            'page-pengaturan-list',

            // Pelayanan
            'page-pelayanan-list',

            // Arsip
            'page-arsip-pelayanan',

            // Layanan
            'page-layanan-daftar',

            // Report
            'page-report-layanan',

            // Content Management - Final approval
            'content-view', 'content-approve', 'content-schedule', 
            'content-withdraw', 'content-publish', 'content-review',

            // Disposisi Operations - Approval
            'disposisi-view', 'disposisi-approve', 'disposisi-process',

            // Pelayanan Operations - Final approval
            'pelayanan-view', 'pelayanan-approve', 'pelayanan-complete',

            // Arsip Operations - View only
            'arsip-view',

            // Layanan Operations - View only
            'layanan-jenis-view', 'layanan-output-view', 'layanan-syarat-view',

            // Report Operations
            'report-view', 'report-export',
        ]);
        $this->command->info('✅ Redaktur - Permissions assigned');

        // =============================================
        // EDITOR - Mereview, menyunting, dan mengirimkan konten untuk persetujuan
        // =============================================
        $editor = Role::findByName('editor');
        $editor->givePermissionTo([
            // Menu Access
            'menu-dashboard', 'menu-pengaturan', 'menu-pelayanan', 
            'menu-arsip', 'menu-layanan',

            // Dashboard
            'page-dashboard',

            // Disposisi
            'page-pengaturan-list',

            // Pelayanan
            'page-pelayanan-input', 'page-pelayanan-list',

            // Arsip
            'page-arsip-pelayanan',

            // Layanan
            'page-layanan-daftar',

            // Content Management - Review dan editing
            'content-create', 'content-edit', 'content-view', 'content-review',

            // Disposisi Operations - Process
            'disposisi-create', 'disposisi-edit', 'disposisi-view', 'disposisi-process',

            // Pelayanan Operations - Process
            'pelayanan-create', 'pelayanan-edit', 'pelayanan-view', 'pelayanan-process',

            // Arsip Operations
            'arsip-create', 'arsip-edit', 'arsip-view',

            // Layanan Operations - Limited
            'layanan-jenis-view', 'layanan-output-view', 'layanan-syarat-view',
        ]);
        $this->command->info('✅ Editor - Permissions assigned');

        // =============================================
        // KONTRIBUTOR - Hanya bisa menulis draf, tidak bisa mempublikasi
        // =============================================
        $kontributor = Role::findByName('kontributor');
        $kontributor->givePermissionTo([
            // Menu Access - Terbatas
            'menu-dashboard', 'menu-pelayanan',

            // Dashboard
            'page-dashboard',

            // Pelayanan - Hanya input
            'page-pelayanan-input',

            // Content Management - Hanya buat draf
            'content-create', 'content-view',

            // Pelayanan Operations - Hanya create
            'pelayanan-create', 'pelayanan-view',
        ]);
        $this->command->info('✅ Kontributor - Permissions assigned');

        // =============================================
        // VIEWER - Hanya bisa melihat konten di backend tanpa bisa mengubah
        // =============================================
        $viewer = Role::findByName('viewer');
        $viewer->givePermissionTo([
            // Menu Access - Read only
            'menu-dashboard', 'menu-arsip', 'menu-layanan', 'menu-report',

            // Dashboard
            'page-dashboard',

            // Arsip - View only
            'page-arsip-pelayanan',

            // Layanan - View only
            'page-layanan-daftar',

            // Report - View only
            'page-report-layanan',

            // Content Management - Read only
            'content-view',

            // Arsip Operations - Read only
            'arsip-view',

            // Layanan Operations - Read only
            'layanan-jenis-view', 'layanan-output-view', 'layanan-syarat-view',

            // Report Operations - Read only
            'report-view',
        ]);
        $this->command->info('✅ Viewer - Permissions assigned');
    }
}