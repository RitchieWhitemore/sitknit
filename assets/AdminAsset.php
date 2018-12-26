<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 17.12.2018
 * Time: 11:56
 */

namespace app\assets;


use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath  = '@app/assets/admin';

    public $css = [
        'css/admin.css'
    ];
    public $js = [
        'js/admin.js'
    ];
    public $depends = [
        'app\assets\WebComponentsAsset',
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}