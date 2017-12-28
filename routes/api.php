<?php

use Illuminate\Http\Request;

Route::get('categories', 'ProductCategoryController@index');
Route::get('categories/{id}', 'ProductCategoryController@show');
Route::get('categories/{id}/products', 'ProductController@findByCategory');

Route::get('products', 'ProductController@index');
Route::get('products/{id}', 'ProductController@show');