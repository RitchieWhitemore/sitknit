<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name'       => 'Сижу-Вяжу.рф',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db'         => [
            'class'             => 'yii\db\Connection',
            'charset'           => 'utf8',
            'enableSchemaCache' => true,
        ],
        'urlManager' => [
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            //'enableStrictParsing' => true,
            'rules'           => [

                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'api/image',
                    'extraPatterns' => [
                        'POST toggle-main'    => 'toggleMain',
                        'DELETE delete-image' => 'deleteImage',
                    ],
                ],

                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'api/good',
                    'extraPatterns' => [
                        'GET category'            => 'category',
                        'DELETE delete-main-good' => 'deleteMainGood',
                    ],
                ],

                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'api/category',
                    'extraPatterns' => [
                        'GET parent' => 'parent',
                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/brand',],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/partner',],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'api/price',
                    'extraPatterns' => [
                        'POST set-price' => 'setPrice',
                    ],
                ],

                ''                                                                               => 'goods/catalog',
                'contact'                                                                        => 'main/contact/index',
                '<_a:error>'                                                                     => 'main/default/<_a>',
                '<_a:(login|logout|signup|confirm-email|request-password-reset|reset-password)>' => 'user/default/<_a>',

                'goods/category/<id:\d+>'      => 'goods/category',
                'goods/category/good/<id:\d+>' => 'goods/view',

                'goods/brand/<id:\d+>' => 'goods/brand'

                /*'<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>'              => '<_m>/<_c>/view',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>'                                    => '<_m>/default/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>'                       => '<_m>/<_c>/index',*/
            ],
        ],
        'mailer'     => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'        => [
            'class' => 'yii\log\Dispatcher',
        ],
    ],
    'params'     => $params,
];