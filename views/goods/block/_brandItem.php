<?php
use yii\helpers\Url;

$model = $model->brand;
?>

<a class="brand__link" href="<?= Url::to(['goods/brand', 'id' => $model->id]) ?>">
    <div class="brand__image-wrapper">
        <?= Yii::$app->thumbnail->img($model->mainImageUrl, [
            'thumbnail'   => [
                'width'  => 125,
                'height' => 125,
            ],
            'placeholder' => [
                'width'  => 125,
                'height' => 125,
            ],
        ], ['alt' => "Изображение категории {$model->name}"])?>
    </div>
    <h3 class="brand__title"><?= $model->name ?><?= isset($model->country) ? (' (' . $model->country->name . ')') : ''?></h3>
</a>