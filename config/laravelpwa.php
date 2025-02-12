<?php

return [
    'name' => 'Catch AND Share',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'C&S',
        'start_url' => '/dashboard',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/C&Sicon-blue.svg',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/C&Sicon-blue.svg',
            '750x1334' => '/images/icons/C&Sicon-blue.svg',
            '828x1792' => '/images/icons/C&Sicon-blue.svg',
            '1125x2436' => '/images/icons/C&Sicon-blue.svg',
            '1242x2208' => '/images/icons/C&Sicon-blue.svg',
            '1242x2688' => '/images/icons/C&Sicon-blue.svg',
            '1536x2048' => '/images/icons/C&Sicon-blue.svg',
            '1668x2224' => '/images/icons/C&Sicon-blue.svg',
            '1668x2388' => '/images/icons/C&Sicon-blue.svg',
            '2048x2732' => '/images/icons/C&Sicon-blue.svg',
        ],

        'shortcuts' => [
            [
                'name' => 'Zavody',
                'description' => 'zkratka na zavody',
                'url' => '/zavody',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]
        ],
        'custom' => []
    ]
];
