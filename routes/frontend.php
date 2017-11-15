<?php 

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

