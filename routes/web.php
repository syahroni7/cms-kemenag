<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('berita.show');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('kategori.show');

