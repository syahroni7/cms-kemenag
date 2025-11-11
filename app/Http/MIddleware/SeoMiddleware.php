<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Default SEO data
        $defaultTitle = 'Kementerian Agama Kabupaten Lebak';
        $defaultDescription = 'Portal resmi Kemenag Lebak yang menyediakan layanan digital, berita, dan informasi keagamaan untuk masyarakat Lebak.';
        $defaultKeywords = 'kemenag lebak, haji lebak, umrah lebak, kua lebak, madrasah lebak, bimbingan keagamaan';
        $defaultImage = asset('blogy-assets/img/logo-cms-kemenag.png');

        // Deteksi halaman secara otomatis
        $path = $request->path();
        $title = $defaultTitle;
        $description = $defaultDescription;
        $keywords = $defaultKeywords;

        if (Str::contains($path, 'berita')) {
            $title = 'Berita Kemenag Lebak Terbaru';
            $description = 'Informasi dan berita terkini seputar kegiatan, layanan, dan program Kementerian Agama Kabupaten Lebak.';
            $keywords = 'berita kemenag lebak, kegiatan keagamaan lebak, informasi kemenag lebak';
        } elseif (Str::contains($path, 'layanan')) {
            $title = 'Layanan Kemenag Lebak';
            $description = 'Pelayanan Haji, Umrah, dan Keagamaan berbasis digital di Kabupaten Lebak.';
            $keywords = 'layanan haji lebak, umrah lebak, pelayanan nikah, kua lebak';
        } elseif (Str::contains($path, 'tentang')) {
            $title = 'Tentang Kemenag Lebak';
            $description = 'Profil, visi, misi, dan struktur organisasi Kementerian Agama Kabupaten Lebak.';
            $keywords = 'profil kemenag lebak, struktur organisasi, visi misi';
        }

        // Bagikan variabel ke semua view
        view()->share([
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keywords' => $keywords,
            'meta_image' => $defaultImage,
        ]);

        return $response;
    }
}
