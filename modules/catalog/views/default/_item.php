<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 *
 * @var $model app\core\entities\Shop\Good\Good
 */
if (isset($model->mainGood)) {
    $values = $model->getValues()->with('characteristic.unit')->indexBy('characteristic.name')->all();
    $valuesMain = $model->mainGood->getValues()->with('characteristic.unit')->indexBy('characteristic.name')->all();
} else {
    $values = $model->getValues()->with('characteristic.unit')->indexBy('characteristic.name')->all();
    $valuesMain = $values;
}

?>
<div class="catalog__item product">
    <a href="<?= Url::to(['good', 'id' => $model->id]) ?>" class="link product__wrapper">
        <h2 class="product__title"><?= $model->category->name ?> <?= $model->name ?></h2>
        <span class="product__manufacturer"><?= $model->brand->name ?></span>
        <div class="product__image-wrapper">
            <?php if (isset($model->mainImage)): ?>
                <img src="<?= Html::encode($model->mainImage->getThumbFileUrl('file_name', 'catalog_list')) ?>" alt=""/>
            <?php else: ?>
                <img src="/img/no-image.svg" alt=""/>
            <?php endif; ?>
        </div>
        <span class="product__color"><?= isset($values['Цвет']) ? $values['Цвет']->value : '' ?></span>
        <ul class="product__characteristic-list">
            <li class="product__characteristics-item">
                <b>Состав:</b> <?= isset($valuesMain['Состав']) ? $valuesMain['Состав']->value : '' ?></li>
            <li class="product__characteristics-item">
                <b>Вес:</b> <?= isset($valuesMain['Вес']) ? $valuesMain['Вес']->value : '' ?> <?= isset($valuesMain['Вес']->goodAttribute) ? $valuesMain['Вес']->goodAttribute->unit->name : '' ?>
            </li>
            <li class="product__characteristics-item">
                <b>Длина:</b> <?= isset($valuesMain['Длина']) ? $valuesMain['Длина']->value : '' ?> <?= isset($valuesMain['Длина']->goodAttribute) ? $valuesMain['Длина']->goodAttribute->unit->name : '' ?>
            </li>
        </ul>
        <div class="product__price-wrapper">
            <span class="product__price"><?= isset($model->priceRetail->price) ? ($model->priceRetail->price . ' руб.') : 'нет цены' ?></span>
        </div>
    </a>
</div>
