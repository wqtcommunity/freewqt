<?php

return [
    // reCaptcha
    'recaptcha' => [
        'enabled'             => false,
        'enable_pages'        => ['login', 'signup'],

        // Site and Secret keys
        'site_key'            => env('RECAPTCHA_SITE_KEY', null),
        'secret_key'          => env('RECAPTCHA_SECRET_KEY', null),
    ],

    'salt' => env('CUSTOM_SALT', 'bgv8PGNcTSUCs62RX'),

    // Do we ask users to optionally enter their e-mail address while signing up?
    'optional_email' => true,

    'admin_route_prefix' => env('ADMIN_ROUTE_PREFIX', 'none'),

    // WARNING: Changing the following settings requires a change in database tables too
    // Tickets
    'tickets' => [
        'length'          => 12, // must be divisible by 2
        'representation'  => 'hex', // hex, int
        'type_enums'      => ['signup','referral','task','game','faucet','other']
    ],
];
