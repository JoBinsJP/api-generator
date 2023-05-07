<?php

return [
    'servers' => [
        'url' => 'https://{environment}.localhost.test',

        'variables' => [
            'environment' => [

                'default' => 'api',

                'enum' => [
                    'api',
                    'api.dev',
                    'api.staging',
                ],
            ],
        ],
    ],

    'openapi' => '3.0.0',
    'title' => 'Reaching APP API',
    'version' => '1.0.0',

    'file-path' => public_path('api-docs/api-docs.json'),
];
