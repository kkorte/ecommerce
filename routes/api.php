<?php

use Illuminate\Http\Request;

Route::get('categories', 'ProductCategoryController@index');
Route::get('categories/{category}', 'ProductCategoryController@show');
Route::get('categories/{category}/products', 'ProductCategoryController@products');

Route::get('products', 'ProductController@index');
Route::get('products/{product}', 'ProductController@show');