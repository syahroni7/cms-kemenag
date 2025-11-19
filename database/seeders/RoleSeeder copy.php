<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. BUAT ROLE
        // ============================================
        $roles = [
            'Superadmin',
            'Administrator',
            'Publisher',
            'Author',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // ============================================
        // 2. DAFTAR PERMISSIONS
        // ============================================
        $permissions = [
            // Dashboard
            'dashboard.view',

            // Posts / Articles
            'post.create',
            'post.edit',
            'post.delete',
            'post.publish',
            'post.unpublish',
            'post.view_all',
            'post.view_own',

            // Categories
            'category.create',
            'category.edit',
            'category.delete',

            // Media Library
            'media.upload',
            'media.delete',

            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Roles & Permissions
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            // Settings
            'setting.update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ============================================
        // 3. ASSIGN PERMISSIONS KE ROLE
        // ============================================

        // ✨ SUPERADMIN → Semua permissions
        $superadmin = Role::where('name', 'Superadmin')->first();
        $superadmin->syncPermissions(Permission::all());

        // ✨ ADMINISTRATOR → Hampir semua kecuali setting sistem
        $administrator = Role::where('name', 'Administrator')->first();
        $administrator->syncPermissions([
            'dashboard.view',
            'post.create', 'post.edit', 'post.delete', 'post.publish', 'post.unpublish', 'post.view_all',
            'category.create', 'category.edit', 'category.delete',
            'media.upload', 'media.delete',
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'role.view',
        ]);

        // ✨ PUBLISHER → Kelola & publikasi konten
        $publisher = Role::where('name', 'Publisher')->first();
        $publisher->syncPermissions([
            'dashboard.view',
            'post.create', 'post.edit', 'post.publish', 'post.unpublish', 'post.view_all',
            'category.create', 'category.edit',
            'media.upload',
        ]);

        // ✨ AUTHOR → Buat, edit, lihat konten sendiri
        $author = Role::where('name', 'Author')->first();
        $author->syncPermissions([
            'dashboard.view',
            'post.create',
            'post.edit',
            'post.view_own',
            'media.upload',
        ]);


        // ============================================
        // 4. ASSIGN ROLE KE USER BERDASARKAN JABATAN
        // ============================================
        $users = User::all();

        foreach ($users as $user) {
            if ($user->jabatan && Role::where('name', $user->jabatan)->exists()) {
                $user->assignRole($user->jabatan);
            }
        }
    }
}
