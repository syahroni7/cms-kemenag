<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\DashboardController as BackendDashboardController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\PengumumanController;

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
| Dashboard (Backend)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [BackendDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| User Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

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
| Resource
|--------------------------------------------------------------------------
*/
Route::resource('berita', BeritaController::class);
Route::resource('pengumuman', PengumumanController::class);

/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
