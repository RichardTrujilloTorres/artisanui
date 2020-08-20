<?php

return [
    'name' => 'ArtisanUI',

    'api' => [
        'prefix' => env('ARTISANUI_API_PREFIX', 'api'),
        'version' => env('ARTISANUI_API_VERSION', 'v1'),
    ],

    'commands' => [
        'namespaces' => [
            'excluded' => [

                'default' => [
                    'help',
                    'list',
                    'packager',
                    'vendor',
                    'ui',
                ],

                'custom' => [
                    // Include here your custom command namespaces which will be ignored
                ],
            ],
        ],
    ],
];
