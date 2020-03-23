<?php


namespace app\modules\catalog\widgets\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class FilterPublicAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/catalog/widgets/assets/dist/';

    public $js = [
        'js/public.filter.js'
    ];

    public $depends = [
        JqueryAsset::class
    ];
}