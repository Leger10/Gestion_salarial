<?php

namespace App\Providers;

use App\Applications\ConfigApplications;
use Illuminate\Pagination\Paginator; // ✅ Bon import
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ConfigApplications::class, function () {
            return new ConfigApplications();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); // ✅ Utilisation correcte de Bootstrap
    }
}
