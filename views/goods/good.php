<?php

/**
 *
 * @var $model app\models\Good
 * @var $values app\models\AttributeValue
 *
 */

?>

<ul class="breadcrumb">
    <li><a href="" class="link breadcrumb__link"><?= $model->category->title?></a></li>
    <li><?= $model->fulltitle ?></li>
</ul>

<div class="page-product">
    <div class="page-product__title-wrapper">
        <h1 class="page-product__title"><?= $model->fulltitle ?></h1>
    </div>
    <div class="page-product__slider-image slider-image">
        <div class="slider-image__main-image-wrapper">
            <a href="<?= $model->getMainImageUrl()?>" target="_blank" class="slider-image__link slider-image__link--active">
                <?= Yii::$app->thumbnail->img($model->getMainImageUrl(), [
                    'thumbnail' => [
                        'width' => 320,
                        'height' => 230,
                    ],
                    'placeholder' => [
                        'width' => 320,
                        'height' => 230
                    ]
                ], ['class' => 'slider-image__main-image']); ?>
            </a>
        </div>
        <div class="slider-image__small-image-wrapper">
            <ul class="slider-image__list">
                <?php foreach ($model->images as $image) : ?>
                <li class="slider-image__item">
                    <a href="<?= $image->url ?>" class="slider-image__link">
                        <?= Yii::$app->thumbnail->img($image->url, [
                            'thumbnail' => [
                                'width' => 70,
                                'height' => 50,
                            ],
                            'placeholder' => [
                                'width' => 70,
                                'height' => 50
                            ]
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
            <li class="page-product__feature-item"><b>Производитель: </b><?= $model->brand->title ?> (<?= $model->country->title ?>)</li>
            <?php foreach ($values as $attr => $value) {
                echo '<li class="page-product__feature-item"><b>' . $attr . ':</b> ' . $value->value . '</li>';
            }
            ?>
            <li class="page-product__feature-item"><b>Товара в упаковке:</b> <?= $model->packaged ?> шт.</li>
        </ul>
        <p class="page-product__existence"><span>в наличии</span> 10 упак.</p>
        <p class="page-product__price-text">цена за штуку: <span class="page-product__price">85 руб.</span>
        </p>
        <p class="page-product__price-text">цена за упаковку: <span class="page-product__price-pack">580 руб.</span>
            <span class="page-product__price-old">620 руб.</span></p>
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
        <p><?= $model->description ?></p>
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
<section class="reviews">
    <h2>Отзывы</h2>
    <p>Здесь вы можете оставить отзыв от товаре</p>
    <form action="" class="reviews__form">
        <div class="review__form-field-wrapper">
            <label>Ваше имя</label>
            <input type="text" class="review__form-field-input" placeholder="Ваше имя"/>
        </div>
        <div class="review__form-field-wrapper">
            <label>Ваш отзыв</label>
            <input type="textarea" class="review__form-field-textarea" placeholder="Ваше отзыв"/>
        </div>
        <div class="review__form-field-wrapper">
            <label>Оценка</label>
            <input type="radio" class="review__form-field-radio" name="review" value="1">
            <input type="radio" class="review__form-field-radio" name="review" value="2">
            <input type="radio" class="review__form-field-radio" name="review" value="3">
            <input type="radio" class="review__form-field-radio" name="review" value="4">
            <input type="radio" class="review__form-field-radio" name="review" value="5">
        </div>
        <button type="submit" class="bnt">Отправить</button>
    </form>
</section>
