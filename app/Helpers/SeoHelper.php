<?php

namespace App\Helpers;

class SeoHelper
{
    public static function meta($title, $description = '', $keywords = '', $image = null)
    {
        view()->share([
            'meta_title' => $title,
            'meta_description' => $description ?: 'Website resmi Kementerian Agama Kabupaten Lebak. Informasi layanan keagamaan, madrasah, haji, nikah, zakat, dan berita terbaru Kemenag Lebak.',
            'meta_keywords' => $keywords ?: 'Kemenag Lebak, Kantor Kementerian Agama Lebak, Portal Kemenag Lebak, Berita Kemenag Lebak, Layanan Keagamaan Lebak',
            'meta_image' => $image ?: asset('blogy-assets/img/logo-cms-kemenag.png'),
        ]);
    }
}
