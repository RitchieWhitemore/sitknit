<?php


namespace app\modules\admin\assets;


use dmstr\web\AdminLteAsset;
use yii\web\AssetBundle;

class SetPricesCSVAsset extends AssetBundle
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
            '/js/papaparse.min.js',
            'js/set.prices.csv.js',
        ];

    public $css = [
        'css/set.prices.css'
    ];

    /**
     * @var array
     */
    public $depends
        = [
            AdminLteAsset::class
        ];
}