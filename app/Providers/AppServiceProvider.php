<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SocialMedia;
use App\Models\Menu;
use App\Helpers\Breadcrumbs;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share data navbar, breadcrumbs, dan sosial media ke semua view
        view()->composer('*', function ($view) {

            // 1. Ambil menu hirarki untuk navbar (recursive)
            $menus = Menu::whereNull('parent_id')
                ->orderBy('order')
                ->with('children')
                ->get();

            // 2. Ambil akun sosial media
            $socialMedias = SocialMedia::all();

            // 3. Ambil breadcrumbs otomatis berdasarkan URL & tabel menus
            $breadcrumbs = Breadcrumbs::generate();

            // 4. Kirim ke view
            $view->with([
                'menus'        => $menus,
                'socialMedias' => $socialMedias,
                'breadcrumbs'  => $breadcrumbs,
            ]);
        });
    }
}
