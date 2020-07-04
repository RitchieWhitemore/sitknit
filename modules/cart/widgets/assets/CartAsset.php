<?php


namespace app\modules\cart\widgets\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;

class CartAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/cart/widgets/assets/dist/';

    public $js = [
        'js/cart.js'
    ];

    public $depends = [
        JqueryAsset::class,
        YiiAsset::class,
    ];
}