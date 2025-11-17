<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\HomeController;


// Roles Permission
Route::prefix('admin')
    ->middleware(['auth', 'role:Administrator|Editor|Author|Kontributor'])
    ->group(function () {
        Route::resource('posts', PostController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class)
            ->middleware('role:Administrator');
    });

// Publik
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});
Route::get('/data-pegawai', [\App\Http\Controllers\Frontend\HomeController::class, 'datapegawai'])->name('frontend.landing.data-pegawai');
Route::get('/kategori', [\App\Http\Controllers\Frontend\HomeController::class, 'kategori'])->name('frontend.landing.kategori');
Route::get('/kontak', [\App\Http\Controllers\Frontend\HomeController::class, 'kontak'])->name('frontend.landing.kontak');

Route::get('/berita/{slug}', [PostController::class, 'show'])->name('berita.show');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('kategori.show');

// Dashboard Admin
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');
