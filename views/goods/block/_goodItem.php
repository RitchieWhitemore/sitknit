<?php

use yii\helpers\Url;

/**
 *
 * @var $model app\models\Good
 */
if (isset($model->mainGood)) {
    $values = $model->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
    $valuesMain = $model->mainGood->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
} else {
    $values = $model->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
    $valuesMain = $values;
}

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
    <li class="product__characteristics-item"><b>Состав:</b> <?= isset($valuesMain['Состав']) ? $valuesMain['Состав']->value : ''?></li>
    <li class="product__characteristics-item"><b>Вес:</b> <?= isset($valuesMain['Вес']) ? $valuesMain['Вес']->value : ''?> <?= isset($valuesMain['Вес']->goodAttribute) ? $valuesMain['Вес']->goodAttribute->unit->name : ''?></li>
    <li class="product__characteristics-item"><b>Длина:</b> <?= isset($valuesMain['Длина']) ? $valuesMain['Длина']->value : ''?> <?= isset($valuesMain['Длина']->goodAttribute) ? $valuesMain['Длина']->goodAttribute->unit->name : ''?></li>
</ul>
<div class="product__price-wrapper">
    <span class="product__price">151 руб.</span>
</div>

