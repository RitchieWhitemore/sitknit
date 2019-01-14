<?php

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=192.168.137.100;dbname=db1066529_sitknit',
            'username' => 'u1066529_sitknit',
            'password' => 'REYO*5RKS0',
        ],
        'mailer' => [
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'richib@yandex.ru',
                'password' => 'A94g14v89',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];