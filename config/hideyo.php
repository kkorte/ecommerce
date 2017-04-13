<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database prefix
    |--------------------------------------------------------------------------
    | We work with a prefix to prefend conflicts. 
    |
    */

    'db_prefix' => 'hideyo_',
    'route_prefix' => 'hideyo',

    'husers' => [
        'driver' => 'eloquent',
        'model' => Hideyo\Backend\Models\User::class,
    ]
    


];
