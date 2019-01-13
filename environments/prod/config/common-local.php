<?php

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=db1066529_sitknit',
            'username' => 'u1066529_sitknit',
            'password' => 'REYO*5RKS0',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];