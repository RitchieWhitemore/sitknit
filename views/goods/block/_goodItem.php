<?php

use yii\helpers\Url;

/**
 *
 * @var $model app\models\Good
 */

$values = $model->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();

?>


<h2 class="product__title"><a href="<?= Url::to(['goods/view', 'id' => $model->id])?>" class="link">Пряжа <?= $model->title ?></a></h2>
<span class="product__manufacturer"><?= $model->brand->title ?></span>
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
    ])?>
</div>
<span class="product__color"><?= isset($values['Цвет']) ? $values['Цвет']->value : ''?></span>
<ul class="product__characteristic-list">
    <li class="product__characteristics-item"><b>Состав:</b> <?= isset($values['Состав']) ? $values['Состав']->value : ''?></li>
    <li class="product__characteristics-item"><b>Вес:</b> <?= isset($values['Вес']) ? $values['Вес']->value : ''?> <?= isset($values['Вес']->goodAttribute) ? $values['Вес']->goodAttribute->unit->name : ''?></li>
    <li class="product__characteristics-item"><b>Длина:</b> <?= isset($values['Длина']) ? $values['Длина']->value : ''?> <?= isset($values['Длина']->goodAttribute) ? $values['Длина']->goodAttribute->unit->name : ''?></li>
</ul>
<div class="product__price-wrapper">
    <span class="product__price">151 руб.</span>
</div>

