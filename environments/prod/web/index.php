<?php
use yii\helpers\ArrayHelper;

require ('auth.php');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = ArrayHelper::merge(
    require(__DIR__ . '/../config/common.php'),
    require(__DIR__ . '/../config/common-local.php'),
    require(__DIR__ . '/../config/web.php'),
    require(__DIR__ . '/../config/web-local.php')
);

(new yii\web\Application($config))->run();
