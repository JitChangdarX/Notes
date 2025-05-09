<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'google_users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'google_users',
        ],
        'signup' => [
            'driver' => 'session',
            'provider' => 'users',  // This is correctly pointing to users provider
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Signup::class,  // This is correct for your Signup model
        ],
        'google_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\GoogleUser::class,
        ],
    ],

    'passwords' => [
        'google_users' => [
            'provider' => 'google_users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];