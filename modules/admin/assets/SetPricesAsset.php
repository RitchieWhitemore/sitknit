<?php


namespace app\modules\admin\assets;


use dmstr\web\AdminLteAsset;
use yii\web\AssetBundle;

class SetPricesAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/admin/assets/dist';

    /**
     * @var array
     */
    public $js
        = [
            'js/set.prices.js',
        ];

    public $css = [];

    /**
     * @var array
     */
    public $depends
        = [
            AdminLteAsset::class
        ];
}