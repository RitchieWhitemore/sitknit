<?php

use yii\helpers\Url;

/**
 * @var $model \app\models\Category
 */
?>


<a href="<?= Url::to(['goods/category', 'id' => $model->id])?>"><h2 class="product__title"><?= $model->title ?></h2></a>
<div class="product__image-wrapper">
    <?= Yii::$app->thumbnail->img($model->mainImageUrl, [
        'thumbnail'   => [
            'width'  => 220,
            'height' => 150,
        ],
        'placeholder' => [
            'width'  => 220,
            'height' => 150,
        ],
    ], ['alt' => "Изображение категории {$model->title}"])?>
</div>
<p class="product__descr"><?= $model->description ?></p>

