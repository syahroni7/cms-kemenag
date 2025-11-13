<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SocialMedia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share data social media ke semua view
        view()->composer('frontend.layouts.footer', function ($view) {
            $view->with('socialMedias', SocialMedia::all());
        });
    }
}