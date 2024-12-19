<?php

return [

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('0f9a8ae710a50db568cb'),
            'secret' => env('bc2233fcd37773a47d43'),
            'app_id' => env('1914377'),
            'options'=>[
                'cluster' => env('us2'),
                'use_tls' => true,
            ],
            
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];