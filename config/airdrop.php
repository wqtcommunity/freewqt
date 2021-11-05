<?php

return [
    // Should we store unidentifiable IP Address hash for signup limits?
    'ip_limit' => [
        'enabled' => true,
        'minutes' => 1440
    ],

    // Check if user is behind VPN/Proxy
    'detect_proxy' => [
        'enabled'         => true,
        'ban'             => false, // if false, they have to wait!
        'waiting_minutes' => 2
    ],
];
