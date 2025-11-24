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
        // Assign Permission ke Roles
        // =======================

        // SUPER ADMIN → Full Access
        $superAdmin = Role::where('name', 'super_administrator')->first();
        $superAdmin->syncPermissions(Permission::all());

        // ADMIN → Hampir semua
        $admin = Role::where('name', 'administrator')->first();
        $admin->syncPermissions([
            'menu-dashboard', 'page-dashboard',

            'menu-main',
            'page-main-permission', 'page-main-user-data',
            'page-main-user-role', 'page-main-unit_pengolah',

            'menu-pelayanan',
            'page-pelayanan-input', 'page-pelayanan-list',

            'menu-arsip',
            'page-arsip-pelayanan',

            'menu-layanan',
            'page-layanan-jenis', 'page-layanan-output',
            'page-layanan-daftar', 'page-layanan-syarat-master',
            'page-layanan-syarat-list',

            'menu-report',
            'page-report-layanan',
        ]);

        // PUBLISHER
        $publisher = Role::where('name', 'publisher')->first();
        $publisher->syncPermissions([
            'menu-dashboard', 'page-dashboard',

            'menu-pelayanan',
            'page-pelayanan-input', 'page-pelayanan-list',

            'menu-arsip',
            'page-arsip-pelayanan',

            'menu-report',
            'page-report-layanan',
        ]);

        // AUTHOR
        $author = Role::where('name', 'author')->first();
        $author->syncPermissions([
            'menu-dashboard', 'page-dashboard',

            'menu-pelayanan',
            'page-pelayanan-list',

            'menu-arsip',
            'page-arsip-pelayanan',

            'menu-disposisi',
            'page-disposisi-list', 'page-disposisi-master',

            'menu-layanan',
            'page-layanan-daftar', 'page-layanan-syarat-master',
            'page-layanan-syarat-list',
        ]);

        $this->command->info('Role permissions assigned successfully!');
    }
}