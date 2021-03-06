<?php

$config = [
    'id' => 'app',
    'layout' => 'common',
    'language' => 'ru-RU',
    //'defaultRoute' => 'main/default/index',
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'formatter' => [
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y в H:i:s',
            'timeFormat' => 'php:H:i:s',
        ],
        'request' => [
            'baseUrl'=> '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ]
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'cart' => [
            'class' => 'app\modules\cart\Module',
        ],
        'catalog' => [
            'class' => 'app\modules\catalog\Module',
            'layout' => '@app/views/layouts/catalog',
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'trade' => [
            'class' => 'app\modules\trade\Module',
            'layout' => '@app/modules/admin/views/layouts/main',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
