<?php

namespace app\widgets\pagination\assets;

use yii\web\AssetBundle;

/**
 * Class LinkPagerAsset
 *
 * @package app\modules\navigator\widgets\pagination\assets
 */
class LinkPagerAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/pagination/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'js/dynamic-link-pager.js',
    ];

    /**
     * @var array
     */
    public $depends = [
//        AppAsset::class
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
