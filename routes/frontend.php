<?php 


Route::get('{productCategorySlug}/{productId}/{productSlug}/{leadingAttributeId?}/{combinations?}', array('as' => 'product.item', 'uses' => 'ProductController@getIndex'));

Route::get('/{slug}', array('as' => 'product-category.item', 'uses' => 'ProductCategoryController@getItem'));
Route::get('/', array('as' => 'index', 'uses' => 'BasicController@index'));
