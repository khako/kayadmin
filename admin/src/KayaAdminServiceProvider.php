<?php

namespace Kaya\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'kaya/admin');

        $this->publishes([
            __DIR__ . '/config.php' => config_path('kayadmin.php')
        ]);

        Route::middleware('web')->group(__DIR__ . '/routes/web.php');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
