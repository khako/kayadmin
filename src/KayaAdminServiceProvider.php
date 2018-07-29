<?php namespace Kaya\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class KayadminServiceProvider extends ServiceProvider {
    protected $namespace='Kaya\Admin\Controllers';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        /**
         * Loading the views
         */
        $this->loadViewsFrom(__DIR__ . '/Views', 'kaya/admin');

        /**
         * Publishing the assets
         */
        $this->publishes([ __DIR__ . '/Build'=> public_path('kaya/admin')], 'public');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {}
}