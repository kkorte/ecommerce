<?php




Route::group(['prefix' => config()->get('hideyo.route_prefix').'/admin', 'namespace' => 'Hideyo\Backend\Controllers', 'middleware' => ['web','auth.hideyo.backend']], function () {
  
    Route::resource('/', 'DashboardController');
    Route::get('dashboard/stats/revenue-by-year/{year}', array('as' => 'admin.dashboard.stats', 'uses' => 'Hideyo\Shop\Controllers\Backend\DashboardController@getStatsRevenueByYear'));
    Route::get('dashboard/stats/order-average-by-year/{year}', array('as' => 'admin.dashboard.stats.average', 'uses' => 'Hideyo\Shop\Controllers\Backend\DashboardController@getStatsOrderAverageByYear'));
    
    Route::get('dashboard/stats/browser-by-year/{year}', array('as' => 'admin.dashboard.stats.browser', 'uses' => 'Hideyo\Shop\Controllers\Backend\DashboardController@getStatsBrowserByYear'));
    Route::get('dashboard/stats/totals-by-year/{year}', array('as' => 'admin.dashboard.stats.total', 'uses' => 'Hideyo\Shop\Controllers\Backend\DashboardController@getStatsTotalsByYear'));
    Route::get('dashboard/stats/payment-method-by-year/{year}', array('as' => 'admin.dashboard.stats.payment.method', 'uses' => 'Hideyo\Shop\Controllers\Backend\DashboardController@getStatsPaymentMethodByYear'));
       
        
    Route::get('dashboard/stats', array('as' => 'admin.dashboard.stats', 'uses' => 'Hideyo\Shop\Controllers\Backend\DashboardController@showStats'));
    Route::resource('dashboard', 'Hideyo\Shop\Controllers\Backend\DashboardController');
 
    Route::resource('shop', 'ShopController', ['names' => [
        'index' => 'hideyo.shop.index',
        'create' => 'hideyo.shop.create',
        'store' => 'hideyo.shop.store',
        'edit' => 'hideyo.shop.edit',
        'update' => 'hideyo.shop.update',
        'destroy' => 'hideyo.shop.destroy'
    ]]);

  
    Route::get('redirect/export', array('as' => 'admin.redirect.export', 'uses' => 'RedirectController@getExport'));

    Route::get('redirect/import', array('as' => 'admin.redirect.import', 'uses' => 'RedirectController@getImport'));
    Route::post('redirect/import', array('as' => 'admin.redirect.import', 'uses' => 'RedirectController@postImport'));




    Route::resource('/redirect', 'RedirectController');



    // Route::resource('/content', 'ContentController');

 //Route::resource('inventory', 'InventoryController');
    Route::resource('tax-rate', 'TaxRateController');
    Route::resource('general-setting', 'GeneralSettingController');
    Route::resource('error', 'ErrorController');
    Route::resource('sending-method', 'SendingMethodController');
    Route::resource('payment-method', 'PaymentMethodController');
    Route::resource('sending-payment-method-related', 'SendingPaymentMethodRelatedController');

    Route::resource('recipe/{recipeId}/images', 'RecipeImageController');
 
    Route::get('recipe/edit/{recipeId}/seo', array('as' => 'admin.recipe.edit_seo', 'uses' => 'RecipeController@editSeo'));

    Route::get('recipe/refactor-images', array('as' => 'recipe.refactor.images', 'uses' => 'RecipeController@refactorAllImages'));
 
    Route::get('recipe/re-directory-images', array('as' => 'recipe.re.directory.images', 'uses' => 'RecipeController@reDirectoryAllImages'));
 


    Route::resource('recipe', 'RecipeController');
 

    Route::resource('content/{contentId}/images', 'ContentImageController');
    Route::get('content/edit/{contentId}/seo', array('as' => 'admin.content.edit_seo', 'uses' => 'ContentController@editSeo'));

    Route::resource('content', 'ContentController');
    Route::resource('content-group', 'ContentGroupController');
    Route::get('content-group/edit/{contentGroupId}/seo', array('as' => 'admin.content-group.edit_seo', 'uses' => 'ContentGroupController@editSeo'));


    Route::get('news/refactor-images', array('as' => 'news.refactor.images', 'uses' => 'NewsController@refactorAllImages'));
 
    Route::get('news/re-directory-images', array('as' => 'news.re.directory.images', 'uses' => 'NewsController@reDirectoryAllImages'));
 

    Route::resource('news/{newsId}/images', 'NewsImageController');

    Route::get('news/edit/{newsId}/seo', array('as' => 'admin.news.edit_seo', 'uses' => 'NewsController@editSeo'));

    Route::resource('news', 'NewsController');

    Route::resource('news-group', 'NewsGroupController');

    Route::get('news-group/edit/{newsGroupId}/seo', array('as' => 'admin.news-group.edit_seo', 'uses' => 'NewsGroupController@editSeo'));


    Route::resource('faq', 'FaqItemController');

    Route::resource('html-block/{htmlBlockId}/copy', 'HtmlBlockController@copy');
    Route::get('html-block/change-active/{htmlBlockId}', array('as' => 'admin.html.block.change-active', 'uses' => 'HtmlBlockController@changeActive'));
 

    Route::post('html-block/{htmlBlockId}/copy', array('as' => 'html.block.store.copy', 'uses' => 'HtmlBlockController@storeCopy'));
 
    Route::resource('html-block', 'HtmlBlockController');

    Route::get('landing-page/refactor-images', array('as' => 'landing.page.refactor.images', 'uses' => 'LandingPageController@refactorAllImages'));
 
    Route::get('landing-page/re-directory-images', array('as' => 'landing.page.re.directory.images', 'uses' => 'LandingPageController@reDirectoryAllImages'));
 
    Route::resource('landing-page', 'LandingPageController');
    Route::get('landing-page/change-active/{landingPageId}', array('as' => 'admin.landing-page.change-active', 'uses' => 'LandingPageController@changeActive'));

    Route::resource('box/{boxId}/download', 'BoxController@download');
    Route::resource('box', 'BoxController');
    Route::resource('coupon-group', 'CouponGroupController');
    Route::resource('coupon', 'CouponController');
    

    Route::get('order/print/products', array('as' => 'admin.order.print.products', 'uses' => 'OrderController@getPrintOrders'));
    
    Route::get('order/print', array('as' => 'admin.order.print', 'uses' => 'OrderController@getPrint'));
    Route::post('order/print', array('as' => 'admin.order.print', 'uses' => 'OrderController@postPrint'));
  
      Route::post('order/print/download', array('as' => 'admin.order.download.print', 'uses' => 'OrderController@postDownloadPrint'));
  
    Route::resource('order', 'OrderController');
    Route::post('order/update-status/{orderId}', array('as' => 'order.update-status', 'uses' => 'OrderController@updateStatus'));
 
    Route::get('order/update-sending-method/{sendingMethodId}', array('as' => 'order.update.sending.method', 'uses' => 'OrderController@updateSendingMethod'));
    Route::get('order/update-payment-method/{paymentMethodId}', array('as' => 'order.update.payment.method', 'uses' => 'OrderController@updatePaymentMethod'));


    Route::resource('order/{orderId}/download', 'OrderController@download');
    Route::resource('order/{orderId}/download-label', 'OrderController@downloadLabel');

    Route::resource('order-status', 'OrderStatusController');
    Route::resource('order-status-email-template', 'OrderStatusEmailTemplateController');
    Route::get('order-status-email-template/show-template/{id}', array('as' => 'order.status.email.template.ajax.show', 'uses' => 'OrderStatusEmailTemplateController@showAjaxTemplate'));



    Route::get('order/update-billing-address/{addressId}', array('as' => 'order.update.billing.address', 'uses' => 'OrderController@updateClientBillAddress'));
    Route::get('order/update-delivery-address/{addressId}', array('as' => 'order.update.delivery.address', 'uses' => 'OrderController@updateClientDeliveryAddress'));

    Route::post('order/add-client', array('as' => 'admin.order.add-client', 'uses' => 'OrderController@addClient'));

    Route::post('order/add-product', array('as' => 'admin.order.add-product', 'uses' => 'OrderController@addProduct'));

    Route::get('order/update-amount-product/{productId}/{amount}', array('as' => 'admin.order.update.amount.product', 'uses' => 'OrderController@updateAmountProduct'));
 

    Route::get('order/change-product-combination/{productId}/{newProductId}', array('as' => 'admin.order.change.product.combination', 'uses' => 'OrderController@changeProductCombination'));
 

    Route::get('order/delete-product/{productId}', array('as' => 'order.delete-product', 'uses' => 'OrderController@deleteProduct'));




    Route::resource('invoice', 'InvoiceController');
    Route::resource('invoice/{invoiceId}/download', 'InvoiceController@download');

    Route::post('client/export', array('as' => 'admin.client.export', 'uses' => 'ClientController@postExport'));

    Route::get('client/export', array('as' => 'admin.client.export', 'uses' => 'ClientController@getExport'));


    Route::resource('client', 'ClientController');

    Route::get('client/{clientId}/activate', array('as' => 'admin.client.activate', 'uses' => 'ClientController@getActivate'));
    Route::get('client/{clientId}/de-activate', array('as' => 'admin.client.deactivate', 'uses' => 'ClientController@getDeActivate'));





    Route::post('client/{clientId}/activate', array('as' => 'admin.client.activate', 'uses' => 'ClientController@postActivate'));
    Route::post('client/{clientId}/de-activate', array('as' => 'admin.client.de-activate', 'uses' => 'ClientController@postDeActivate'));


    Route::resource('client/{clientId}/addresses', 'ClientAddressController');
    Route::resource('client/{clientId}/order', 'ClientOrderController');

    Route::resource('attribute-group/{attributeGroupId}/attributes', 'AttributeController');
    Route::resource('attribute-group', 'AttributeGroupController');

    Route::resource('extra-field/{extraFieldId}/values', 'ExtraFieldDefaultValueController');
    Route::resource('extra-field', 'ExtraFieldController');

    Route::get('product/refactor-images', array('as' => 'product.refactor-images', 'uses' => 'ProductController@refactorAllImages'));
    Route::get('product/re-directory-images', array('as' => 'product.re-directory-images', 'uses' => 'ProductController@reDirectoryAllImages'));



    Route::post('product/export', array('as' => 'admin.product.export', 'uses' => 'ProductController@postExport'));

    Route::get('product/export', array('as' => 'admin.product.export', 'uses' => 'ProductController@getExport'));

    Route::get('product/rank', array('as' => 'admin.product.ranking', 'uses' => 'ProductController@getRank'));


    Route::resource('product', 'ProductController');
    Route::get('product/edit/{productId}/price', array('as' => 'admin.product.edit_price', 'uses' => 'ProductController@editPrice'));
    Route::get('product/change-active/{productId}', array('as' => 'admin.product.change-active', 'uses' => 'ProductController@changeActive'));
    Route::get('product/change-amount/{productId}/{amount}', array('as' => 'admin.product.change-amount', 'uses' => 'ProductController@changeAmount'));
    Route::get('product/change-rank/{productId}/{rank}', array('as' => 'admin.product.change-rank', 'uses' => 'ProductController@changeRank'));
  
 
    Route::get('product/edit/{productId}/seo', array('as' => 'admin.product.edit_seo', 'uses' => 'ProductController@editSeo'));
    Route::resource('product/{productId}/images', 'ProductImageController');
    Route::resource('product/{productId}/product-amount-option', 'ProductAmountOptionController');
    Route::resource('product/{productId}/product-amount-series', 'ProductAmountSeriesController');

    Route::resource('product/{productId}/copy', 'ProductController@copy');


    Route::resource('product/{productId}/product-combination', 'ProductCombinationController');


    Route::get('product/{productId}/product-combination/change-amount-attribute/{id}/{amount}', array('as' => 'admin.product.change-amount', 'uses' => 'ProductCombinationController@changeAmount'));
 

     Route::resource('product-waiting-list', 'ProductWaitingListController');
 
    Route::post('product/{productId}/copy', array('as' => 'product.store-copy', 'uses' => 'ProductController@storeCopy'));
    Route::resource('product/{productId}/product-extra-field-value', 'ProductExtraFieldValueController');
    Route::resource('product/{productId}/related-product', 'ProductRelatedProductController');
    Route::get('product-category/refactor-images', array('as' => 'product-category.refactor-images', 'uses' => 'ProductCategoryController@refactorAllImages'));
    Route::get('product-category/re-directory-images', array('as' => 'product-category.re-directory-images', 'uses' => 'ProductCategoryController@reDirectoryAllImages'));

    Route::resource('brand/{brandId}/images', 'BrandImageController');
 
    Route::get('brand/edit/{brandId}/seo', array('as' => 'admin.brand.edit_seo', 'uses' => 'BrandController@editSeo'));
 

    Route::resource('brand', 'BrandController');

    Route::get('product-category/change-active/{productCategoryId}', array('as' => 'admin.product-category.change-active', 'uses' => 'ProductCategoryController@changeActive'));
    Route::resource('product-category', 'ProductCategoryController');
    Route::resource('product-tag-group', 'ProductTagGroupController');
    Route::get('product_category/get_ajax_categories', array('as' => 'admin.product-category.ajax_categories', 'uses' => 'ProductCategoryController@ajaxCategories'));
    Route::get('product_category/get_ajax_category/{id}', array('as' => 'admin.product-category.ajax_category', 'uses' => 'ProductCategoryController@ajaxCategory'));
 
    Route::get('product_category/edit/{productCategoryId}/hightlight', array('as' => 'admin.product-category.edit.hightlight', 'uses' => 'ProductCategoryController@editHighlight'));


    Route::resource('product-category/{productCategoryId}/images', 'ProductCategoryImageController');
    Route::get('product_category/edit/{productCategoryId}/seo', array('as' => 'admin.product-category.edit_seo', 'uses' => 'ProductCategoryController@editSeo'));

    Route::get('product_category/ajax-root-tree', array('as' => 'admin.product-category.ajax-root-tree', 'uses' => 'ProductCategoryController@ajaxRootTree'));
    Route::get('product_category/ajax-children-tree', array('as' => 'admin.product-category.ajax-children-tree', 'uses' => 'ProductCategoryController@ajaxChildrenTree'));
    Route::get('product_category/ajax-move-node', array('as' => 'admin.product-category.ajax-move-node', 'uses' => 'ProductCategoryController@ajaxMoveNode'));

    Route::get('product_category/tree', array('as' => 'admin.product-category.tree', 'uses' => 'ProductCategoryController@tree'));

    Route::resource('user', 'UserController'); // return the protected resource
    Route::get('profile/shop/change/{shopId}', array('as' => 'change.language.profile', 'uses' => 'UserController@changeShopProfile'));
    Route::get('profile', array('as' => 'edit.profile', 'uses' => 'UserController@editProfile'));
    Route::post('profile', array('as' => 'update.profile', 'uses' => 'UserController@updateProfile'));
    Route::post('profile_language', array('as' => 'update.language', 'uses' => 'UserController@updateLanguage'));
});


Route::group(['prefix' => config()->get('hideyo.route_prefix').'/admin', 'namespace' => 'Hideyo\Backend\Controllers', 'middleware' => ['web']], function () {
    Route::get('/security/login', 'AuthController@getLogin');
    Route::post('/security/login', 'AuthController@postLogin');
    Route::get('/security/logout', 'AuthController@getLogout');
});



