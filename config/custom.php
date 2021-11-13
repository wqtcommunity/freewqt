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

    // Tickets
    // WARNING: Don't change after launch
    'tickets' => [
        'length'                 => env('TICKET_LENGTH', 8), // 8 = from 10,000,0000 to 99,999,999 (89,999,999 tickets max, and middle point will be 50,000,000)
        'type_enums'             => ['signup','referral','task','game','faucet','other']
    ],

    // Referral increment ids
    // WARNING: Don't change after launch
    'referrer_id_increment_by' => 1500
];
