<?php 


//product routes
Route::get('{productCategorySlug}/{productId}/{productSlug}/{leadingAttributeId?}/{combinations?}', array('as' => 'product.item', 'uses' => 'ProductController@getIndex'));


//productCategory routes
Route::get('/{slug}', array('as' => 'product-category.item', 'uses' => 'ProductCategoryController@getItem'));

//other
Route::get('/', array('as' => 'index', 'uses' => 'BasicController@index'));
