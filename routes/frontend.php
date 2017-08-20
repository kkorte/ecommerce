<?php 



Route::get('/{slug}', array('as' => 'product-category', 'uses' => 'ProductCategoryController@getItem'));
Route::get('/', array('as' => 'index', 'uses' => 'BasicController@index'));
