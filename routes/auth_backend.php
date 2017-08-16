<?php

   Route::get('/security/login', 'AuthController@getLogin');
    Route::post('/security/login', 'AuthController@postLogin');
    Route::get('/security/logout', array('as' => 'hideyo.security.logout', 'uses' => 'AuthController@getLogout'));
