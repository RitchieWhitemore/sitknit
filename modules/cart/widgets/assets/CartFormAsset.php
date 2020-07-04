<?php


namespace app\modules\cart\widgets\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class CartFormAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/cart/widgets/assets/dist/';

    public $js = [
        'js/cart.form.js'
    ];

    public $depends = [
        JqueryAsset::class
    ];
}