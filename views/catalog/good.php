<?php

use app\assets\MagnificPopupAsset;
use app\core\repositories\Shop\BalanceRepository;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 *
 * @var $good app\core\entities\Shop\Good\Good
 * @var $values app\core\entities\Shop\Good\Value
 * @var $valuesMain app\core\entities\Shop\Good\Value
 */

MagnificPopupAsset::register($this);

$balance = new BalanceRepository($good);

$this->title = $good->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $good->category->name, 'url' => ['category', 'id' => $good->category_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [
            'class' => 'breadcrumb'
    ]
]) ?>

<div class="page-product">
    <div class="page-product__title-wrapper">
        <h1 class="page-product__title"><?= $good->fullName ?></h1>
    </div>
    <div class="page-product__slider-image slider-image">
        <div class="slider-image__main-image-wrapper">
            <a href="<?= Html::encode($good->mainOriginImageUrl) ?>" target="_blank"
               class="slider-image__link slider-image__link--active">
                    <img src="<?= Html::encode($good->mainThumbImageUrl) ?>" alt=""/>
            </a>
        </div>
        <div class="slider-image__small-image-wrapper">
            <ul class="slider-image__list">
                <?php foreach ($good->images as $i => $image) : ?>
                    <li class="slider-image__item <?= $i > 0 ? "slider-item": ""?>">
                        <a href="<?= Html::encode($image->getUploadedFileUrl('file_name')) ?>" class="slider-image__link">
                            <img src="<?= Html::encode($image->getThumbFileUrl('file_name', 'catalog_list')) ?>" alt=""/>
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
            <li class="page-product__feature-item"><b>Производитель: </b><?= $good->brand->name ?>
                (<?= $good->brand->country->name ?>)
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
            <li class="page-product__feature-item"><b>Товара в упаковке:</b> <?= $good->packaged ?> шт.</li>
        </ul>
        <p class="page-product__existence"><span>в наличии</span> <?= $balance->getQty() ?> шт.</p>
        <p class="page-product__price-text">цена за штуку: <span class="page-product__price"><?= isset($good->priceRetail->price) ? ($good->priceRetail->price . ' руб') : 'нет цены' ?></span>

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
            if (!empty($good->description) || !isset($good->mainGood)) {
                echo $good->description;
            } else {
                echo $good->mainGood->description;
            }
            ?></p>
    </div>
</div>
<!--<section class="more-color">
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
</section>-->


<?php $js = <<<EOD
$('.slider-image__main-image-wrapper, .slider-item').magnificPopup({
    type: 'image',
    delegate: 'a',
    gallery: {
        enabled:true
    }
});
EOD;
$this->registerJs($js); ?>