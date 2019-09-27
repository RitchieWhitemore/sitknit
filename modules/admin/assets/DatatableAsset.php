<?php


namespace app\modules\admin\assets;


use dmstr\web\AdminLteAsset;
use yii\web\AssetBundle;

class DatatableAsset extends AssetBundle
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
            'js/datatables.min.js',
            'js/search.good.remaining.js',

        ];

    public $css = [
        'css/datatables.min.css'
    ];

    /**
     * @var array
     */
    public $depends
        = [
            AdminLteAsset::class
        ];
}