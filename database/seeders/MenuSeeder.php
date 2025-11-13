<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Beranda
        Menu::create([
            'name' => 'Beranda',
            'url' => '/',
            'order' => 1,
        ]);

        // 2. Profile
        $profile = Menu::create([
            'name' => 'Profile',
            'url' => null,
            'order' => 2,
        ]);

        Menu::insert([
            [
                'name' => 'Visi dan Misi',
                'icon' => 'bi bi-bullseye',
                'url' => '#',
                'parent_id' => $profile->id,
                'order' => 1,
            ],
            [
                'name' => 'Struktur Organisasi',
                'icon' => 'bi bi-diagram-3',
                'url' => '#',
                'parent_id' => $profile->id,
                'order' => 2,
            ],
            [
                'name' => 'Tugas Pokok dan Fungsi',
                'icon' => 'bi bi-clipboard-check',
                'url' => '#',
                'parent_id' => $profile->id,
                'order' => 3,
            ],
            [
                'name' => 'Data Pegawai',
                'icon' => 'bi bi-people',
                'url' => 'blog-details.html',
                'parent_id' => $profile->id,
                'order' => 4,
            ],
        ]);

        // 3. Kategori
        Menu::create([
            'name' => 'Kategori',
            'url' => '/kategori',
            'order' => 3,
        ]);

        // 4. Blog Details
        Menu::create([
            'name' => 'Blog Details',
            'url' => 'blog-details.html',
            'order' => 4,
        ]);

        // 5. Interaksi
        $interaksi = Menu::create([
            'name' => 'Interaksi',
            'icon' => 'bi bi-people-fill me-2',
            'url' => null,
            'order' => 5,
        ]);

        Menu::insert([
            [
                'name' => 'Survei',
                'icon' => 'bi bi-bar-chart',
                'url' => 'about.html',
                'parent_id' => $interaksi->id,
                'order' => 1,
            ],
            [
                'name' => 'Suara Anda',
                'icon' => 'bi bi-chat-dots',
                'url' => 'category.html',
                'parent_id' => $interaksi->id,
                'order' => 2,
            ],
            [
                'name' => 'Masukan dan Saran',
                'icon' => 'bi bi-envelope-open',
                'url' => 'blog-details.html',
                'parent_id' => $interaksi->id,
                'order' => 3,
            ],
        ]);

        // 6. Galeri
        $galeri = Menu::create([
            'name' => 'Galeri',
            'url' => null,
            'order' => 6,
        ]);

        Menu::insert([
            [
                'name' => 'Foto',
                'icon' => 'bi bi-camera',
                'url' => '#',
                'parent_id' => $galeri->id,
                'order' => 1,
            ],
            [
                'name' => 'Video',
                'icon' => 'bi bi-play-btn',
                'url' => '#',
                'parent_id' => $galeri->id,
                'order' => 2,
            ],
            [
                'name' => 'Infografis',
                'icon' => 'bi bi-bar-chart-fill',
                'url' => '#',
                'parent_id' => $galeri->id,
                'order' => 3,
            ],
        ]);

        // 7. Berita
        $berita = Menu::create([
            'name' => 'Berita',
            'url' => null,
            'order' => 7,
        ]);

        Menu::insert([
            [
                'name' => 'Nasional',
                'icon' => 'bi bi-flag',
                'url' => '#',
                'parent_id' => $berita->id,
                'order' => 1,
            ],
            [
                'name' => 'Daerah',
                'icon' => 'bi bi-geo-alt',
                'url' => '#',
                'parent_id' => $berita->id,
                'order' => 2,
            ],
        ]);

        // 8. Pengumuman
        Menu::create([
            'name' => 'Pengumuman',
            'icon' => 'bi bi-megaphone me-2',
            'url' => '#',
            'order' => 8,
        ]);

        // 9. Kontak
        Menu::create([
            'name' => 'Kontak',
            'url' => '/kontak',
            'order' => 9,
        ]);
    }
}
