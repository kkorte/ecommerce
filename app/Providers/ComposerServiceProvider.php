<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\CartComposer;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...

        View::composer('*', 'App\Http\ViewComposers\FooterComposer');
        View::composer('*', 'App\Http\ViewComposers\ProductCategoryComposer');
        View::composer('*', 'App\Http\ViewComposers\CartComposer');
        View::composer('*', 'App\Http\ViewComposers\ShopComposer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
