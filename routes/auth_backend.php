<?php

Route::get('/security/login', 'AuthController@getLogin');
Route::post('/security/login', 'AuthController@postLogin');
Route::get('/security/logout', array('as' => 'security.logout', 'uses' => 'AuthController@getLogout'));