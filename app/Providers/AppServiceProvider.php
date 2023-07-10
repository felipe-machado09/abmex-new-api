<?php

namespace App\Providers;

use Illuminate\Support\Facades\{Config};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $defaultPerPage = Config::get('pagination.default');

        \Illuminate\Pagination\Paginator::defaultView($defaultPerPage);
        \Illuminate\Pagination\Paginator::defaultSimpleView($defaultPerPage);
    }
}
