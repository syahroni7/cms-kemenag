<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SocialMedia;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share data navbar dan footer ke semua view frontend
        view()->composer('*', function ($view) {
            
            // Ambil Menu Hirarki Recursive
            $menus = Menu::whereNull('parent_id')
                ->orderBy('order')
                ->with('children') // recursive otomatis
                ->get();

            // Ambil semua sosial media
            $socialMedias = SocialMedia::all();

            $view->with([
                'menus' => $menus,
                'socialMedias' => $socialMedias,
            ]);
        });
    }
}
