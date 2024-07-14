<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

   

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'guru' => [
            'driver' => 'session',
            'provider' => 'gurus',
        ],
        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

   
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'gurus' => [
            'driver' => 'eloquent',
            'model' => App\Models\Guru::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    

    'password_timeout' => 10800,

];
