<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider {
    
    /**
     * Note: please keep logic in this repository. Put logic not in models,
     * Information about models in Laravel: http://laravel.com/docs/5.1/eloquent
     * @author     Matthijs Neijenhuijs <matthijs@dutchbridge.nl>
     * @copyright  DutchBridge - dont share/steel!
     */
    
    public function register()
    {

        $this->app->bind(
            'Hideyo\Repositories\ShopRepositoryInterface', 
            'Hideyo\Repositories\ShopRepository');


        $this->app->bind(
            'Hideyo\Repositories\ProductCombinationRepositoryInterface', 
            'Hideyo\Repositories\ProductCombinationRepository');

        $this->app->bind(
            'Hideyo\Repositories\AttributeRepositoryInterface', 
            'Hideyo\Repositories\AttributeRepository');

        $this->app->bind(
            'Hideyo\Repositories\AttributeGroupRepositoryInterface', 
            'Hideyo\Repositories\AttributeGroupRepository');

        $this->app->bind(
            'Hideyo\Repositories\LanguageRepositoryInterface', 
            'Hideyo\Repositories\LanguageRepository');

        $this->app->bind(
            'Hideyo\Repositories\UserRepositoryInterface', 
            'Hideyo\Repositories\UserRepository');

        $this->app->bind(
            'Hideyo\Repositories\RoleRepositoryInterface', 
            'Hideyo\Repositories\RoleRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductRepositoryInterface', 
            'Hideyo\Repositories\ProductRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductImageRepositoryInterface', 
            'Hideyo\Repositories\ProductImageRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductRelatedProductRepositoryInterface', 
            'Hideyo\Repositories\ProductRelatedProductRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductExtraFieldValueRepositoryInterface', 
            'Hideyo\Repositories\ProductExtraFieldValueRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductVariationRepositoryInterface', 
            'Hideyo\Repositories\ProductVariationRepository');

        $this->app->bind(
            'Hideyo\Repositories\ExtraFieldRepositoryInterface', 
            'Hideyo\Repositories\ExtraFieldRepository');

        $this->app->bind(
            'Hideyo\Repositories\ExtraFieldDefaultValueRepositoryInterface', 
            'Hideyo\Repositories\ExtraFieldDefaultValueRepository');

        $this->app->bind(
            'Hideyo\Repositories\CouponRepositoryInterface', 
            'Hideyo\Repositories\CouponRepository');

        $this->app->bind(
            'Hideyo\Repositories\GiftVoucherRepositoryInterface', 
            'Hideyo\Repositories\GiftVoucherRepository');

        $this->app->bind(
            'Hideyo\Repositories\DiscountRepositoryInterface', 
            'Hideyo\Repositories\DiscountRepository');



        $this->app->bind(
            'Hideyo\Repositories\CouponGroupRepositoryInterface', 
            'Hideyo\Repositories\CouponGroupRepository');


        $this->app->bind(
            'Hideyo\Repositories\ClientRepositoryInterface', 
            'Hideyo\Repositories\ClientRepository');

        $this->app->bind(
            'Hideyo\Repositories\WholesaleClientRepositoryInterface', 
            'Hideyo\Repositories\WholesaleClientRepository');


        $this->app->bind(
            'Hideyo\Repositories\ClientAddressRepositoryInterface', 
            'Hideyo\Repositories\ClientAddressRepository');

        $this->app->bind(
            'Hideyo\Repositories\WholesaleClientAddressRepositoryInterface', 
            'Hideyo\Repositories\WholesaleClientAddressRepository');


        $this->app->bind(
            'Hideyo\Repositories\ProductCategoryRepositoryInterface', 
            'Hideyo\Repositories\ProductCategoryRepository');

        $this->app->bind(
            'Hideyo\Repositories\ContentCategoryRepositoryInterface', 
            'Hideyo\Repositories\ContentCategoryRepository');

        $this->app->bind(
            'Hideyo\Repositories\ContentCategoryImageRepositoryInterface', 
            'Hideyo\Repositories\ContentCategoryImageRepository');

        $this->app->bind(
            'Hideyo\Repositories\ContentRepositoryInterface', 
            'Hideyo\Repositories\ContentRepository');

        $this->app->bind(
            'Hideyo\Repositories\ContentImageRepositoryInterface', 
            'Hideyo\Repositories\ContentImageRepository');

        $this->app->bind(
            'Hideyo\Repositories\HtmlBlockRepositoryInterface', 
            'Hideyo\Repositories\HtmlBlockRepository');

        $this->app->bind(
            'Hideyo\Repositories\ShopRepositoryInterface', 
            'Hideyo\Repositories\ShopRepository');

        $this->app->bind(
            'Hideyo\Repositories\UserLogRepositoryInterface', 
            'Hideyo\Repositories\UserLogRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductCategoryImageRepositoryInterface', 
            'Hideyo\Repositories\ProductCategoryImageRepository');

        $this->app->bind(
            'Hideyo\Repositories\TaxRateRepositoryInterface', 
            'Hideyo\Repositories\TaxRateRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductVariationTypeRepositoryInterface', 
            'Hideyo\Repositories\ProductVariationTypeRepository');

        $this->app->bind(
            'Hideyo\Repositories\PaymentMethodRepositoryInterface', 
            'Hideyo\Repositories\PaymentMethodRepository');


        $this->app->bind(
            'Hideyo\Repositories\SendingMethodRepositoryInterface', 
            'Hideyo\Repositories\SendingMethodRepository');

        $this->app->bind(
            'Hideyo\Repositories\OrderRepositoryInterface', 
            'Hideyo\Repositories\OrderRepository');

        $this->app->bind(
            'Hideyo\Repositories\OrderAddressRepositoryInterface', 
            'Hideyo\Repositories\OrderAddressRepository');

        $this->app->bind(
            'Hideyo\Repositories\OrderStatusEmailTemplateRepositoryInterface', 
            'Hideyo\Repositories\OrderStatusEmailTemplateRepository');

        $this->app->bind(
            'Hideyo\Repositories\OrderStatusRepositoryInterface', 
            'Hideyo\Repositories\OrderStatusRepository');

        $this->app->bind(
            'Hideyo\Repositories\OrderPaymentLogRepositoryInterface', 
            'Hideyo\Repositories\OrderPaymentLogRepository');


        $this->app->bind(
            'Hideyo\Repositories\SendingPaymentMethodRelatedRepositoryInterface', 
            'Hideyo\Repositories\SendingPaymentMethodRelatedRepository');

        $this->app->bind(
            'Hideyo\Repositories\CollectionRepositoryInterface', 
            'Hideyo\Repositories\CollectionRepository');

        $this->app->bind(
            'Hideyo\Repositories\RedirectRepositoryInterface', 
            'Hideyo\Repositories\RedirectRepository');


        $this->app->bind(
            'Hideyo\Repositories\InvoiceRepositoryInterface', 
            'Hideyo\Repositories\InvoiceRepository');

        $this->app->bind(
            'Hideyo\Repositories\InvoiceAddressRepositoryInterface', 
            'Hideyo\Repositories\InvoiceAddressRepository');

        $this->app->bind(
            'Hideyo\Repositories\ProductAmountOptionRepositoryInterface', 
            'Hideyo\Repositories\ProductAmountOptionRepository');



        $this->app->bind(
            'Hideyo\Repositories\ProductAmountSeriesRepositoryInterface', 
            'Hideyo\Repositories\ProductAmountSeriesRepository');


        $this->app->bind(
            'Hideyo\Repositories\GeneralSettingRepositoryInterface', 
            'Hideyo\Repositories\GeneralSettingRepository');

        $this->app->bind(
            'Hideyo\Repositories\FaqItemRepositoryInterface', 
            'Hideyo\Repositories\FaqItemRepository');



    }
}