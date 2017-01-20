<?php

namespace Hideyo\Shop;

use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/hideyo.php' => config_path('hideyo.php'),
        ]);


        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/Routes/frontend.php';
        $this->app->make('Hideyo\Shop\Controllers\Frontend\BasicController');
    }
}
