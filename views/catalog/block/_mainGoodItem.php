<?php

use yii\helpers\Url;

/**
 *
 * @var $model app\core\entities\Shop\Good\Good
 */

$values = $model->valuesYarnRelation;

?>
<div class="catalog__item product">
    <a href="<?= Url::to(['good', 'id' => $model->getMainGoodId()]) ?>" class="link">
        <h2 class="product__title"><?= $model->getCategoryName() ?> <?= $model->name ?></h2>
        <span class="product__manufacturer"><?= $model->brand->name ?></span>
        <div class="product__image-wrapper">
            <img src="<?= $model->getMainThumbImageUrl() ?>"
                 alt="">
        </div>
        <ul class="product__characteristic-list">
            <?php foreach ($values as $value) : ?>
                <li class="product__characteristics-item">
                    <b><?= $value->characteristic->name ?>
                        :</b> <?= $value->value ?> <?= $value->characteristic->unit->name ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="product__price-wrapper">
            <span class="product__price"><?= isset($model->retailPrice->price) ? ($model->retailPrice->price . ' руб.') : 'нет цены' ?></span>
        </div>
    </a>
</div>
