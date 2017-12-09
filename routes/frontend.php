<?php 
  

Route::get('account/login', array('as' => 'account.login', 'uses' => 'AccountController@getLogin'));

//Account    
Route::post('account/login', array('as' => 'account.login', 'uses' => 'AccountController@postLogin'));
Route::get('account/logout', 'AccountController@getLogout');

Route::get('account/forgot-password', 'AccountController@getForgotPassword');
Route::post('account/forgot-password', 'AccountController@postForgotPassword');

Route::get('account/reset-password/{code}/{email}', 'AccountController@getResetPassword');
Route::post('account/reset-password/{code}/{email}', 'AccountController@postResetPassword');

Route::post('account/subscribe-newsletter', array('as' => 'account.newsletter.subscribe', 'uses' => 'AccountController@postSubscriberNewsletter'));

Route::get('account/confirm/{code}/{email}', 'AccountController@getConfirm');
Route::get('account/check-zipcode/{zipcode?}/{housenumber?}', 'AccountController@getZipcode');

Route::get('account/register', array('as' => 'account.register', 'uses' => 'AccountController@getRegister'));
Route::post('account/register', array('as' => 'account.register', 'uses' => 'AccountController@postRegister'));
Route::get('account/forgot-password', array('as' => 'account.forgot.password', 'uses' => 'AccountController@getForgotPassword'));
Route::post('account/forgot-password', array('as' => 'account.forgot.password', 'uses' => 'AccountController@postForgotPassword'));

Route::group(['middleware' => 'auth'], function () {
    Route::get('/account', 'AccountController@getIndex');
    Route::get('/account/edit-account', 'AccountController@getEditAccount');
    Route::post('/account/edit-account', 'AccountController@postEditAccount');
    Route::get('/account/edit-address/{type}', 'AccountController@getEditAddress');
    Route::post('/account/edit-address/{type}', 'AccountController@postEditAddress');
    Route::get('/account/download-order/{orderId}', 'AccountController@getDownloadOrder');
});



Route::get('product/select-second-pulldown/{productId}/{leadingAttributeId}/{SecondAttributeId}', array('as' => 'product.select-second-pulldown', 'uses' => 'ProductController@getSelectLeadingPulldown'));
Route::get('product/select-leading-pulldown/{productId}/{attributeId}', array('as' => 'product.select-leading-pulldown', 'uses' => 'ProductController@getSelectLeadingPulldown'));

Route::get('cart/update-sending-method/{sendingMethodId}', array('as' => 'cart.update.sending.method', 'uses' => 'CartController@updateSendingMethod'));
Route::get('cart/update-payment-method/{paymentMethodId}', array('as' => 'cart.update.payment.method', 'uses' => 'CartController@updatePaymentMethod'));

Route::get('cart/checkout', array('as' => 'cart.checkout', 'uses' => 'CheckoutController@checkout'));
Route::post('cart/checkout', array('as' => 'cart.checkout', 'uses' => 'CheckoutController@checkout'));


Route::get('cart/total-reload', array('as' => 'cart.total-reload', 'uses' => 'CartController@getTotalReload'));
Route::get('cart/dialog', array('as' => 'cart.dialog', 'uses' => 'CartController@getBasketDialog'));
Route::get('cart/update-amount-product/{productId}/{amount}', array('as' => 'cart.update.amount.product', 'uses' => 'CartController@updateAmountProduct'));
Route::get('cart/delete-product/{productId}', array('as' => 'cart.delete.product', 'uses' => 'CartController@deleteProduct'));
Route::get('cart', array('as' => 'cart.index', 'uses' => 'CartController@getIndex'));

//product routes
Route::get('{productCategorySlug}/{productId}/{productSlug}/{leadingAttributeId?}/{combinations?}', array('as' => 'product.item', 'uses' => 'ProductController@getIndex'));


//productCategory routes
Route::get('/{slug}', array('as' => 'product-category.item', 'uses' => 'ProductCategoryController@getItem'));

//Cart
Route::post('cart/post-product/{productId}/{productCombinationId?}', array('as' => 'cart.add.product', 'uses' => 'CartController@postProduct'));
Route::get('cart/delete-product/{productId}', array('as' => 'cart.delete.product', 'uses' => 'CartController@deleteProduct'));


//other
Route::get('/', array('as' => 'index', 'uses' => 'BasicController@index'));

