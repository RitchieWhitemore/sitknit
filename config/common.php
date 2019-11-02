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
            'on afterOpen' => function ($event) {
                $event->sender->createCommand("SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';")->execute();
            },
        ],
        'i18n' => [
            'class' => 'yii\i18n\I18N',
            'translations' => [
                'system' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
                ],
            ],
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
                        'GET list'                => 'list',
                        'GET category'            => 'category',
                        'GET group-by-name'       => 'groupByName',
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

                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'api/receipt',
                    'extraPatterns' => [
                        'POST save' => 'save',
                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/receiptItem',],

                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'api/order',
                    'extraPatterns' => [
                        'POST save' => 'save',
                    ],
                ],

                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/orderItem',],

                'catalog/<slug:[\w_-]+>' => 'catalog/category',
                'catalog/good/<id:\d+>' => 'catalog/good',

                ''                                                                               => 'catalog',
                'contact'                                                                        => 'main/contact/index',
                '<_a:error>'                                                                     => 'main/default/<_a>',
                '<_a:(login|logout|signup|confirm-email|password-reset-request|reset-password)>' => 'user/default/<_a>',



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