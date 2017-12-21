<?php

use Illuminate\Http\Request;

Route::get('products', 'ProductController@index');
Route::get('products/{product}', 'ProductController@show');