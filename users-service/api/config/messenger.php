<?php

return [

    'transports' => [

        'async' => [
            'dsn' => env('MESSENGER_TRANSPORT_DSN', 'doctrine://default'),
        ],

        'rabbitmq' => [
            'dsn' => env('RABBITMQ_DSN'),
        ],

    ],
];
