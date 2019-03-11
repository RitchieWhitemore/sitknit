<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'jshd3qjaxp',
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@app/runtime/logs/web-error.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@app/runtime/logs/web-warning.log'
                ],
            ],
        ],
    ],
    'bootstrap' => [
        'debug', 'gii'
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['*'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['0'],
        ]
    ]
];