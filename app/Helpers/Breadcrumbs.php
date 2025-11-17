<?php

namespace App\Helpers;

use App\Models\Menu;

class Breadcrumbs
{
    public static function generate()
    {
        $path = trim(request()->path(), '/');

        // Homepage → tidak ada breadcrumbs
        if ($path === '') {
            return [];
        }

        // Cari menu otomatis
        $menu = Menu::all()->first(function ($m) use ($path) {
            return trim($m->normalized_url) === $path;
        });

        if ($menu) {
            return self::buildPath($menu);
        }

        // Cari berdasarkan segmen pertama — untuk URL dinamis
        $firstSegment = request()->segment(1);
        $menu = Menu::all()->first(function ($m) use ($firstSegment) {
            return trim($m->normalized_url) === trim($firstSegment);
        });

        if ($menu) {
            return self::buildPath($menu);
        }

        // fallback otomatis
        return self::fallback();
    }

    private static function buildPath($menu)
    {
        $path = [];

        while ($menu) {
            $path[] = [
                'label' => $menu->name,
                'url'   => url($menu->url),
                'icon'  => $menu->icon
            ];

            $menu = $menu->parent;
        }

        return array_reverse($path);
    }

    private static function fallback()
    {
        $segments = request()->segments();
        $breadcrumbs = [];
        $url = '';

        foreach ($segments as $seg) {
            $url .= '/' . $seg;

            $breadcrumbs[] = [
                'label' => ucwords(str_replace('-', ' ', $seg)),
                'url' => url($url),
                'icon' => null
            ];
        }

        return $breadcrumbs;
    }
}
