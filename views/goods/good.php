<?php

use app\components\Balance;
use yii\helpers\Url;

/**
 *
 * @var $model \app\models\Good
 * @var $values \app\core\entities\Shop\Good\Value
 * @var $valuesMain \app\core\entities\Shop\Good\Value
 */

$balance = new Balance($model);

?>

<ul class="breadcrumb">
    <li><a href="<?= Url::to(['/goods/category', 'id' => $model->category_id])?>" class="link breadcrumb__link"><?= $model->category->name ?></a></li>
    <li><a href="<?= Url::to(['/goods/brand', 'id' => $model->brand_id])?>" class="link breadcrumb__link"><?= $model->brand->name ?></a></li>
    <li><?= $model->fullName ?></li>
</ul>

<div class="page-product">
    <div class="page-product__title-wrapper">
        <h1 class="page-product__title"><?= $model->fullName ?></h1>
    </div>
    <div class="page-product__slider-image slider-image">
        <div class="slider-image__main-image-wrapper">
            <a href="<?= $model->getMainImageUrl() ?>" target="_blank"
               class="slider-image__link slider-image__link--active">
                <?= Yii::$app->thumbnail->img($model->getMainImageUrl(), [
                    'thumbnail'   => [
                        'width'  => 320,
                        'height' => 230,
                    ],
                    'placeholder' => [
                        'width'  => 320,
                        'height' => 230,
                    ],
                ], ['class' => 'slider-image__main-image']); ?>
            </a>
        </div>
        <div class="slider-image__small-image-wrapper">
            <ul class="slider-image__list">
                <?php foreach ($model->images as $image) : ?>
                    <li class="slider-image__item">
                        <a href="<?= $image->url ?>" class="slider-image__link">
                            <?= Yii::$app->thumbnail->img($image->url, [
                                'thumbnail'   => [
                                    'width'  => 70,
                                    'height' => 50,
                                ],
                                'placeholder' => [
                                    'width'  => 70,
                                    'height' => 50,
                                ],
                            ], ['class' => 'slider-image__small-image']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button class="slider-image__next">Вперед</button>
            <button class="slider-image__prev">Назад</button>
        </div>
    </div>
    <div class="page-product__feature">
        <h2 class="page-product__feature-title">Характеристики:</h2>
        <ul class="page-product__feature-list">
            <li class="page-product__feature-item"><b>Производитель: </b><?= $model->brand->name ?>
                (<?= $model->brand->country->name ?>)
            </li>
            <?php
            foreach ($valuesMain as $attr => $value) {
                $unit = isset($value->goodAttribute->unit) ? $value->goodAttribute->unit->name : '';
                if ($attr == 'Цвет') {
                    echo '<li class="page-product__feature-item"><b>' . $attr . ':</b> ' . $values[$attr]->value . ' ' . $unit . '</li>';
                }
                else {
                    echo '<li class="page-product__feature-item"><b>' . $attr . ':</b> ' . $value->value . ' ' . $unit . '</li>';
                }

            }
            ?>
            <li class="page-product__feature-item"><b>Товара в упаковке:</b> <?= $model->packaged ?> шт.</li>
        </ul>
        <p class="page-product__existence"><span>в наличии</span> <?= $balance->getQty() ?> шт.</p>
        <p class="page-product__price-text">цена за штуку: <span class="page-product__price"><?= isset($model->priceRetail->price) ? ($model->priceRetail->price . ' руб') : 'нет цены' ?></span>

        <form action="" class="page-product__qty-form">
            <div class="page-product__qty-wrapper">
                <input type="text" class="page-product__qty" name="qty" placeholder="10"/>
                <button type="button" class="page-product__button-minus">-</button>
                <button type="button" class="page-product__button-plus">+</button>
            </div>
            <span class="page-product__unit">шт. (1 упак)</span>
            <button type="submit" class="page-product__cart">В корзину</button>
        </form>
    </div>
    <div class="page-product__descr">
        <h2>Описание:</h2>
        <p><?php
            if (!empty($model->description) || !isset($model->mainGood)) {
                echo $model->description;
            } else {
                echo $model->mainGood->description;
            }
            ?></p>
    </div>
</div>
<section class="more-color">
    <h2>Другие цвета пряжи KLANGWELTEN</h2>
    <div class="more-color__item">
        <img src="img/yarn-small-1.png" width="144" height="74"/>
        <p class="more-color__color">Зелено-малиновый (9040)</p>
    </div>
    <div class="more-color__item">
        <img src="img/yarn-small-1.png" width="144" height="74"/>
        <p class="more-color__color">Зелено-малиновый (9040)</p>
    </div>
    <div class="more-color__item">
        <img src="img/yarn-small-1.png" width="144" height="74"/>
        <p class="more-color__color">Зелено-малиновый (9040)</p>
    </div>
    <div class="more-color__item">
        <img src="img/yarn-small-1.png" width="144" height="74"/>
        <p class="more-color__color">Зелено-малиновый (9040)</p>
    </div>
    <div class="more-color__item">
        <img src="img/yarn-small-1.png" width="144" height="74"/>
        <p class="more-color__color">Зелено-малиновый (9040)</p>
    </div>
    <div class="more-color__item">
        <img src="img/yarn-small-1.png" width="144" height="74"/>
        <p class="more-color__color">Зелено-малиновый (9040)</p>
    </div>
    <div class="more-color__item">
        <img src="img/yarn-small-1.png" width="144" height="74"/>
        <p class="more-color__color">Зелено-малиновый (9040)</p>
    </div>
</section>
