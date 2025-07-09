<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use CyrildeWit\EloquentViewable\Views;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \CyrildeWit\EloquentViewable\Contracts\Views::class,
            \App\Services\Views\Views::class
        );

        $this->app->bind(
            \CyrildeWit\EloquentViewable\Contracts\View::class,
            \App\Models\View::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
    }
}
