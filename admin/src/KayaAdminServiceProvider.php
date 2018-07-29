<?php

namespace Kaya\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;


class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('admin', 'Kaya\Admin\Middlewares\AdminMiddleware');

        /** TO REMOVE */
        Schema::defaultStringLength(191);
         /** TO REMOVE */
         
        $this->loadViewsFrom(__DIR__ . '/views', 'kaya/admin');

        $this->publishes([
            __DIR__ . '/config.php' => config_path('kayadmin.php')
        ]);

        Route::middleware('web', 'admin')->group(__DIR__ . '/routes/web.php');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config.php',
            'kayadmin'
        );
    }
}
