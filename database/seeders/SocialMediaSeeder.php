<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialMedia;

class SocialMediaSeeder extends Seeder
{
    public function run(): void
    {
        SocialMedia::create([
            'platform_name' => 'Youtube',
            'profile_url' => 'https://youtube.com/channel/UCaaABoAgqifjWAlJ7B8DxVw/about',
            'icon_class' => 'bi bi-youtube'
        ]);

        SocialMedia::create([
            'platform_name' => 'Facebook',
            'profile_url' => 'https://facebook.com/people/Kantor-Kemenag-Lebak/61571915549770/',
            'icon_class' => 'bi bi-facebook'
        ]);

        SocialMedia::create([
            'platform_name' => 'Instagram',
            'profile_url' => 'https://instagram.com/kemenaglebak',
            'icon_class' => 'bi bi-instagram'
        ]);

        SocialMedia::create([
            'platform_name' => 'Tiktok',
            'profile_url' => 'https://tiktok.com/kemenag.lebak',
            'icon_class' => 'bi bi-tiktok'
        ]);
    }
}
