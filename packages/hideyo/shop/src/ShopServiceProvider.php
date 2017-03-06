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

        $this->app->bind(
            'Hideyo\Shop\Repositories\BrandRepositoryInterface',
            'Hideyo\Shop\Repositories\BrandRepository'
        );
        
        $this->app->bind(
            'Hideyo\Shop\Repositories\BlogRepositoryInterface',
            'Hideyo\Shop\Repositories\BlogRepository'
        );
        
        $this->app->bind(
            'Hideyo\Shop\Repositories\RedirectRepositoryInterface',
            'Hideyo\Shop\Repositories\RedirectRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductCombinationRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductCombinationRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\AttributeGroupRepositoryInterface',
            'Hideyo\Shop\Repositories\AttributeGroupRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\AttributeRepositoryInterface',
            'Hideyo\Shop\Repositories\AttributeRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\LanguageRepositoryInterface',
            'Hideyo\Shop\Repositories\LanguageRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\UserRepositoryInterface',
            'Hideyo\Shop\Repositories\UserRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\RoleRepositoryInterface',
            'Hideyo\Shop\Repositories\RoleRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductRelatedProductRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductRelatedProductRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductExtraFieldValueRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductExtraFieldValueRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ExtraFieldDefaultValueRepositoryInterface',
            'Hideyo\Shop\Repositories\ExtraFieldDefaultValueRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ExtraFieldRepositoryInterface',
            'Hideyo\Shop\Repositories\ExtraFieldRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\CouponRepositoryInterface',
            'Hideyo\Shop\Repositories\CouponRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\ClientRepositoryInterface',
            'Hideyo\Shop\Repositories\ClientRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ClientAddressRepositoryInterface',
            'Hideyo\Shop\Repositories\ClientAddressRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductCategoryRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductCategoryRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ShopRepositoryInterface',
            'Hideyo\Shop\Repositories\ShopRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\UserLogRepositoryInterface',
            'Hideyo\Shop\Repositories\UserLogRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductAmountOptionRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductAmountOptionRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductAmountSeriesRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductAmountSeriesRepository'
        );



        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductTagGroupRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductTagGroupRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\ProductWaitingListRepositoryInterface',
            'Hideyo\Shop\Repositories\ProductWaitingListRepository'
        );



        $this->app->bind(
            'Hideyo\Shop\Repositories\TaxRateRepositoryInterface',
            'Hideyo\Shop\Repositories\TaxRateRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\PaymentMethodRepositoryInterface',
            'Hideyo\Shop\Repositories\PaymentMethodRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\SendingMethodRepositoryInterface',
            'Hideyo\Shop\Repositories\SendingMethodRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\OrderRepositoryInterface',
            'Hideyo\Shop\Repositories\OrderRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\OrderAddressRepositoryInterface',
            'Hideyo\Shop\Repositories\OrderAddressRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\OrderPaymentLogRepositoryInterface',
            'Hideyo\Shop\Repositories\OrderPaymentLogRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\OrderStatusRepositoryInterface',
            'Hideyo\Shop\Repositories\OrderStatusRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\OrderStatusEmailTemplateRepositoryInterface',
            'Hideyo\Shop\Repositories\OrderStatusEmailTemplateRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\InvoiceRepositoryInterface',
            'Hideyo\Shop\Repositories\InvoiceRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\InvoiceAddressRepositoryInterface',
            'Hideyo\Shop\Repositories\InvoiceAddressRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\SendingPaymentMethodRelatedRepositoryInterface',
            'Hideyo\Shop\Repositories\SendingPaymentMethodRelatedRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\RecipeRepositoryInterface',
            'Hideyo\Shop\Repositories\RecipeRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\NewsRepositoryInterface',
            'Hideyo\Shop\Repositories\NewsRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\ContentRepositoryInterface',
            'Hideyo\Shop\Repositories\ContentRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\FaqItemRepositoryInterface',
            'Hideyo\Shop\Repositories\FaqItemRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\HtmlBlockRepositoryInterface',
            'Hideyo\Shop\Repositories\HtmlBlockRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\BoxRepositoryInterface',
            'Hideyo\Shop\Repositories\BoxRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\LandingPageRepositoryInterface',
            'Hideyo\Shop\Repositories\LandingPageRepository'
        );


        $this->app->bind(
            'Hideyo\Shop\Repositories\GeneralSettingRepositoryInterface',
            'Hideyo\Shop\Repositories\GeneralSettingRepository'
        );

        $this->app->bind(
            'Hideyo\Shop\Repositories\ExceptionRepositoryInterface',
            'Hideyo\Shop\Repositories\ExceptionRepository'
        );


    }
}
