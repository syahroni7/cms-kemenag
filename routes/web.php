<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\DashboardController as BackendDashboardController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\PengumumanController;

// =======================
// NEW CONTROLLERS (Tambahkan ini)
// =======================
use App\Http\Controllers\Backend\DataPengguna\PermissionController;
use App\Http\Controllers\Backend\UserDataController;
use App\Http\Controllers\Backend\UserRoleController;
use App\Http\Controllers\Backend\UnitPengolahController;
use App\Http\Controllers\Backend\DisposisiListController;
use App\Http\Controllers\Backend\DisposisiMasterController;
use App\Http\Controllers\Backend\DaftarPelayananController;
use App\Http\Controllers\Backend\ArsipPelayananController;
use App\Http\Controllers\Backend\JenisLayananController;
use App\Http\Controllers\Backend\OutputLayananController;
use App\Http\Controllers\Backend\DaftarLayananController;
use App\Http\Controllers\Backend\SyaratLayananMasterController;
use App\Http\Controllers\Backend\SyaratLayananListController;
use App\Http\Controllers\Backend\LaporanLayananController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/data-pegawai', 'datapegawai')->name('frontend.landing.data-pegawai');
    Route::get('/kategori', 'kategori')->name('frontend.landing.kategori');
    Route::get('/kontak', 'kontak')->name('frontend.landing.kontak');
    Route::get('/struktur-organisasi', 'strukturorganisasi')->name('frontend.landing.struktur-organisasi');
});

/*
|--------------------------------------------------------------------------
| Dashboard & Backend Routes (Protected by Auth)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // =======================
    // DASHBOARD
    // =======================
    Route::get('/dashboard', [BackendDashboardController::class, 'index'])->name('dashboard');

    // =======================
    // DATA UTAMA
    // =======================
    // Di routes/web.php, dalam middleware auth
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    Route::prefix('users')->group(function () {
        // User Data
        Route::get('/data', [UserDataController::class, 'index'])->name('user-data.index');

        // User Roles
        Route::get('/roles', [UserRoleController::class, 'index'])->name('user-roles.index');
    });

    Route::prefix('unit-pengolah')->group(function () {
        Route::get('/', [UnitPengolahController::class, 'index'])->name('unit-pengolah.index');
        // Tambahkan routes lain untuk unit pengolah jika needed
    });

    // =======================
    // DISPOSISI
    // =======================
    Route::prefix('disposisi')->group(function () {
        // Disposisi List dengan parameter status
        Route::get('/list/{status?}', [DisposisiListController::class, 'index'])->name('disposisi-list.index');

        // Disposisi Master
        Route::get('/master', [DisposisiMasterController::class, 'index'])->name('disposisi-master.index');
    });

    // =======================
    // PELAYANAN
    // =======================
    Route::prefix('daftar-pelayanan')->group(function () {
        // Input/Lacak Pelayanan (Create)
        Route::get('/create', [DaftarPelayananController::class, 'create'])->name('daftar-pelayanan.create');

        // Daftar Pelayanan dengan parameter status
        Route::get('/{status?}', [DaftarPelayananController::class, 'index'])->name('daftar-pelayanan.index');
    });

    // =======================
    // ARSIP
    // =======================
    Route::prefix('arsip-pelayanan')->group(function () {
        Route::get('/', [ArsipPelayananController::class, 'index'])->name('arsip-pelayanan.index');
    });

    // =======================
    // MASTER LAYANAN
    // =======================
    Route::prefix('jenis-layanan')->group(function () {
        Route::get('/', [JenisLayananController::class, 'index'])->name('jenis-layanan.index');
    });

    Route::prefix('output-layanan')->group(function () {
        Route::get('/', [OutputLayananController::class, 'index'])->name('output-layanan.index');
    });

    Route::prefix('daftar-layanan')->group(function () {
        Route::get('/', [DaftarLayananController::class, 'index'])->name('daftar-layanan.index');
    });

    Route::prefix('syarat-layanan')->group(function () {
        // Master Syarat
        Route::get('/master', [SyaratLayananMasterController::class, 'index'])->name('syarat-layanan-master.index');

        // Daftar Syarat
        Route::get('/list', [SyaratLayananListController::class, 'index'])->name('syarat-layanan-list.index');
    });

    // =======================
    // LAPORAN
    // =======================
    Route::prefix('laporan-layanan')->group(function () {
        Route::get('/{type?}', [LaporanLayananController::class, 'index'])->name('laporan-layanan.index');
    });

    // =======================
    // EXISTING RESOURCES (Berita & Pengumuman)
    // =======================
    Route::resource('berita', BeritaController::class);
    Route::resource('pengumuman', PengumumanController::class);

    // =======================
    // USER PROFILE
    // =======================

    // Halaman profil (index)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Edit profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Update password (opsional)
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');

    // Hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
