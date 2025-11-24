<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        // Share data navbar, breadcrumbs, sosial media, dan status pelayanan ke semua view
        View::composer('*', function ($view) {
            // 1. Ambil menu hirarki untuk navbar (recursive)
            $menus = Menu::whereNull('parent_id')
                ->orderBy('order')
                ->with('children')
                ->get();

            // 2. Ambil akun sosial media
            $socialMedias = SocialMedia::all();

            // 3. Ambil breadcrumbs otomatis berdasarkan URL & tabel menus
            $breadcrumbs = Breadcrumbs::generate();

            // 4. Data status pelayanan untuk sidebar
            $statusPelayanan = $this->getStatusPelayanan();

            // 5. Kirim semua data ke view
            $view->with([
                'menus'           => $menus,
                'socialMedias'    => $socialMedias,
                'breadcrumbs'     => $breadcrumbs,
                'statusPelayanan' => $statusPelayanan,
            ]);
        });
    }

    /**
     * Get status pelayanan data
     * Bisa dikembangkan untuk mengambil data dinamis dari database
     */
    private function getStatusPelayanan(): array
    {
        // Untuk sekarang menggunakan data statis
        // Nanti bisa diganti dengan query database jika sudah ada model Pelayanan
        return [
            [
                'name'  => 'baru',
                'color' => 'primary',
                'total' => 0, // Ganti dengan: \App\Models\Pelayanan::where('status', 'baru')->count()
                'icon'  => 'bi-circle'
            ],
            [
                'name'  => 'proses',
                'color' => 'warning',
                'total' => 0, // Ganti dengan: \App\Models\Pelayanan::where('status', 'proses')->count()
                'icon'  => 'bi-arrow-clockwise'
            ],
            [
                'name'  => 'selesai',
                'color' => 'success',
                'total' => 0, // Ganti dengan: \App\Models\Pelayanan::where('status', 'selesai')->count()
                'icon'  => 'bi-check-circle'
            ],
            [
                'name'  => 'ditolak',
                'color' => 'danger',
                'total' => 0, // Ganti dengan: \App\Models\Pelayanan::where('status', 'ditolak')->count()
                'icon'  => 'bi-x-circle'
            ]
        ];
    }
}