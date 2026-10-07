<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        // Tampilan pagination sederhana yang cocok dengan CSS website & admin.
        Paginator::defaultView('pagination.site');
        Paginator::defaultSimpleView('pagination.site');
    }
}
