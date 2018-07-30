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
        /** TO REMOVE */
        Schema::defaultStringLength(191);
         /** TO REMOVE */

         /**
          * Register the aliased middleware "admin".
          */
        $router->aliasMiddleware('admin', 'Kaya\Admin\Middlewares\AdminMiddleware');
        
        /**
         * Load the view.
         */
        $this->loadViewsFrom(__DIR__ . '/views', 'kaya/admin');

        /**
         * Publish the config file.
         */
        $this->publishes([
            __DIR__ . '/config.php' => config_path('kayadmin.php')
        ]);
        
        /**
         * Register all the routes.
         */
        Route::middleware('web', 'admin')
        ->prefix('admin')
        ->namespace('Kaya\Admin\Controllers')
        ->group(function () {
            Route::prefix('api')->group(__DIR__ . '/routes/api.php');
            Route::prefix('')->group(__DIR__ . '/routes/web.php');
        });
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
