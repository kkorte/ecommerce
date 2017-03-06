<?php

    Route::get('/productfeed/{productCategoryId}/{productCategorySlug}.xml', array('as' => 'sitemap.productfeed.category', 'uses' => 'SitemapController@getProductFeedByCategory'));

    Route::get('/', 'BasicController@index');

    Route::get('winkelwagen', array('as' => 'cart.index', 'uses' => 'CartController@getIndex'));

    Route::get('cart/dialog', array('as' => 'cart.dialog', 'uses' => 'CartController@getDialog'));

    Route::post('cart/post-product/{productId}/{productCombinationId?}', array('as' => 'cart.add.product', 'uses' => 'CartController@postProduct'));
  
    Route::get('search/query', array('as' => 'search.dialog', 'uses' => 'SearchController@getDialog'));
  
    Route::get('search', array('as' => 'search.index', 'uses' => 'SearchController@getIndex'));
  
    Route::get('cart/edit-address/{$type}', array('as' => 'cart.edit-address', 'uses' => 'CartController@getEditAddress'));
    Route::post('cart/edit-address/{$type}', array('as' => 'cart.edit-address', 'uses' => 'CartController@postEditAddress'));

    Route::get('cart/total-reload', array('as' => 'cart.total.reload', 'uses' => 'CartController@getTotalReload'));
    Route::get('cart/total-reload-mobile', array('as' => 'cart.total.reload.mobile', 'uses' => 'CartController@getTotalReloadMobile'));
    Route::get('cart/present/delete', array('as' => 'cart.present.delete', 'uses' => 'CartController@getDeletePresent'));
    Route::get('cart/present', array('as' => 'cart.present', 'uses' => 'CartController@getPresent'));
    Route::post('cart/present', array('as' => 'cart.present', 'uses' => 'CartController@postPresent'));
    
    Route::post('checkout/report-external', array('as' => 'cart.old.callback', 'uses' => 'CartController@postPaymentExternalCallback'));


    Route::get('cart/update-amount-product/{productId}/{amount}', array('as' => 'cart.update.amount.product', 'uses' => 'CartController@updateAmountProduct'));
    Route::get('cart/update-sending-method/{sendingMethodId}', array('as' => 'cart.update.sending.method', 'uses' => 'CartController@updateSendingMethod'));
    Route::get('cart/update-payment-method/{paymentMethodId}', array('as' => 'cart.update.payment.method', 'uses' => 'CartController@updatePaymentMethod'));

    Route::get('cart/checkout', array('as' => 'cart.checkout', 'uses' => 'CartController@checkout'));
    Route::post('cart/checkout', array('as' => 'cart.checkout', 'uses' => 'CartController@checkout'));


    Route::get('cart/payment', array('as' => 'cart.payment', 'uses' => 'CartController@getPayment'));
    Route::post('cart/payment', array('as' => 'cart.payment', 'uses' => 'CartController@postPayment'));



    Route::post('cart/complete', array('as' => 'cart.complete', 'uses' => 'CartController@postComplete'));

  
    Route::get('cart/delete-product/{productId}', array('as' => 'cart.delete.product', 'uses' => 'CartController@deleteProduct'));
    Route::get('cart/update-coupon-code/{code}', array('as' => 'cart.update.coupon.code', 'uses' => 'CartController@updateCouponCode'));
  
    Route::post('cart/callback/{orderId}', array('as' => 'cart.payment.external.callback', 'uses' => 'CartController@postPaymentExternalCallback'));
    Route::get('cart/callback/{orderId}', array('as' => 'cart.payment.external.callback', 'uses' => 'CartController@postPaymentExternalCallback'));

    Route::resource('cart', 'CartController');





    Route::get('account/login', array('as' => 'account.login', 'uses' => 'AccountController@getLogin'));

    Route::post('account/login', array('as' => 'account.login', 'uses' => 'AccountController@postLogin'));
  


    Route::get('account/forgot-password', array('as' => 'account.forgot.password', 'uses' => 'AccountController@getForgotPassword'));

    Route::post('account/forgot-password', array('as' => 'account.forgot.password', 'uses' => 'AccountController@postForgotPassword'));
  


    Route::get('account/reset-password/{code}/{email}', 'AccountController@getResetPassword');
    Route::post('account/reset-password/{code}/{email}', 'AccountController@postResetPassword');

    Route::get('account/confirm/{code}/{email}', 'AccountController@getConfirm');

    Route::get('account/register', array('as' => 'account.register', 'uses' => 'AccountController@getRegister'));

    Route::post('account/register', array('as' => 'account.register', 'uses' => 'AccountController@postRegister'));
  
    Route::get('/account/change-address-ajax/{type}', array('as' => 'account.change.address.ajax', 'uses' => 'AccountController@getChangeAddressAjax'));

    Route::get('account/reset-account-settings/{code}/{email}', 'AccountController@getResetAccount');
    Route::get('account/check-zipcode/{zipcode?}/{housenumber?}', 'AccountController@getZipcode');
    

    Route::group(['middleware' => 'auth'], function () {
    
        Route::get('account/re-order/{orderId}', array('as' => 'account.re.order', 'uses' => 'AccountController@getReOrder'));
        Route::post('account/re-order/{orderId}', array('as' => 'account.re.order', 'uses' => 'AccountController@postReOrder'));

        Route::get('account/re-order-all', array('as' => 'account.re.order.all', 'uses' => 'AccountController@getReOrderAll'));
        Route::post('account/re-order-all', array('as' => 'account.re.order.all', 'uses' => 'AccountController@postReOrderAll'));




        Route::get('account/download-order/{orderId}', array('as' => 'account.download.order', 'uses' => 'AccountController@getDownloadOrder'));


 
        Route::get('account/edit-address/{type}', array('as' => 'account.edit.address', 'uses' => 'AccountController@getEditAddress'));
        Route::post('account/edit-address/{type}', array('as' => 'account.edit.address', 'uses' => 'AccountController@postEditAddress'));


        Route::get('account/edit-account', array('as' => 'account.edit.account', 'uses' => 'AccountController@getEditAccount'));
        Route::post('account/edit-account', array('as' => 'account.edit.account', 'uses' => 'AccountController@postEditAccount'));


        Route::resource('account', 'AccountController');
    });

    Route::get('/nieuws/ajax', array('as' => 'news.ajax', 'uses' => 'NewsController@getIndexAjax'));
    Route::get('/nieuws/{newsGroupSlug}/{slug}', array('as' => 'news.item', 'uses' => 'NewsController@getItem'));
    Route::get('/nieuws/{newsGroupSlug}', array('as' => 'news.group', 'uses' => 'NewsController@getByGroup'));
    
    Route::get('/nieuws', array('as' => 'news.index', 'uses' => 'NewsController@getIndex'));
    


    Route::get('product/buy-dialog/{productId}/{leadingAttributeId?}/{combinations?}', array('as' => 'product.buy.dialog', 'uses' => 'ProductController@buyDialog'));


    Route::get('product/waiting-list/{productId}/{productAttributeId?}', array('as' => 'product.waiting.list', 'uses' => 'ProductController@waitingList'));

    Route::post('/product/waiting-list/add', array('as' => 'product.waiting.list.add', 'uses' => 'ProductController@postWaitingList'));


    Route::get('product/select-second-pulldown/{productId}/{leadingAttributeId}/{SecondAttributeId}', array('as' => 'product.select-second-pulldown', 'uses' => 'ProductController@getSelectLeadingPulldown'));

    Route::get('product/select-leading-pulldown/{productId}/{attributeId}', array('as' => 'product.select-leading-pulldown', 'uses' => 'ProductController@getSelectLeadingPulldown'));


    Route::get('product/select-leading-pulldown-dialog/{productId}/{attributeId}', array('as' => 'product.select-leading-pulldown-dialog', 'uses' => 'ProductController@getSelectLeadingPulldownDialog'));


    Route::get('product/leading-combination-select/{productId}/{attributeId?}', array('as' => 'product.leading.combination.select', 'uses' => 'ProductController@productLeadingCombinationSelect'));

  
    Route::get('/product-category/ajax/{slug}', array('as' => 'product.category.ajax', 'uses' => 'ProductCategoryController@getBySlugAjax'));


    Route::resource('{categorySlug}/{productId}/{productSlug}/{leadingAttributeId?}/{combinations?}', 'ProductController');

    Route::get('{categorySlug}/{productId}/{productSlug}/{leadingAttributeId?}/{combinations?}', array('as' => 'product.item', 'uses' => 'ProductController@getIndex'));


    Route::get('/sitemap/products.xml', array('as' => 'sitemap.product', 'uses' => 'SitemapController@getProducts'));

    Route::get('/sitemap/categories.xml', array('as' => 'sitemap.product-categories', 'uses' => 'SitemapController@getProductCategories'));

    Route::get('/sitemap.xml', array('as' => 'sitemap.index', 'uses' => 'SitemapController@getIndex'));

    Route::get('/productfeed.xml', array('as' => 'sitemap.productfeed', 'uses' => 'SitemapController@getProductFeedOverview'));


    Route::get('/productfeedall.xml', array('as' => 'sitemap.productfeedall', 'uses' => 'SitemapController@getProductFeedAll'));

    Route::get('/productfeedallbelgium.xml', array('as' => 'sitemap.productfeedall', 'uses' => 'SitemapController@getProductFeedAll'));



    Route::post('/newsletter/add', array('as' => 'newsletter.add', 'uses' => 'NewsletterController@postAdd'));

    Route::get('/contact', array('as' => 'contact', 'uses' => 'BasicController@getContact'));
    Route::post('/contact', array('as' => 'contact', 'uses' => 'BasicController@postContact'));

    Route::get('/veelgestelde-vragen', array('as' => 'faq', 'uses' => 'ContentController@getFaq'));
    Route::get('/merk/{slug}', array('as' => 'brand.item', 'uses' => 'BrandController@getItem'));
    Route::get('/merken-overzicht', array('as' => 'brand.overview', 'uses' => 'BrandController@getIndex'));
    Route::get('/nieuwe-producten', array('as' => 'product.new', 'uses' => 'ProductController@getOverviewNewItems'));
    Route::get('/aanbiedingen', array('as' => 'product.sales', 'uses' => 'ProductController@getOverviewSaleItems'));
    Route::get('/{slug}', array('as' => 'product-category', 'uses' => 'ProductCategoryController@getItem'));
    Route::get('/text/{slug}', array('as' => 'content-item', 'uses' => 'ContentController@getItem'));
