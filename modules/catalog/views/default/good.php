<?php

use app\assets\MagnificPopupAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 *
 * @var $good app\core\entities\Shop\Good\Good
 * @var $otherColors \app\core\entities\Shop\Good\Good[]
 * @var $values app\core\entities\Shop\Good\Value
 * @var $valuesMain app\core\entities\Shop\Good\Value
 * @var $category \app\core\entities\Shop\Category
 */

MagnificPopupAsset::register($this);

$balance = (new \app\core\readModels\Shop\RemainingReadRepository())->getBalanceOfGood($good->id);


$this->title = $good->fullName . ' - ' . $good->color;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['category', 'slug' => $category->slug]];
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
                        <li class="slider-image__item <?= $i > 0 ? "slider-item" : "" ?>">
                            <a href="<?= Html::encode($image->getUploadedFileUrl('file_name')) ?>"
                               class="slider-image__link">
                                <img src="<?= Html::encode($image->getThumbFileUrl('file_name', 'catalog_list')) ?>"
                                     alt=""/>
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
                    (<?= isset($good->brand->country) ? $good->brand->country->name : '' ?>)
                </li>
                <?php foreach ($good->values as $value) : ?>
                    <li class="page-product__feature-item"><b><?= $value->characteristic->name ?>
                            :</b> <?= $value->value ?> <?= $value->characteristic->getUnitName() ?> </li>
                <?php endforeach; ?>
                <li class="page-product__feature-item"><b>Товара в упаковке:</b> <?= $good->packaged ?> шт.</li>
            </ul>
            <p class="page-product__existence"><span>в наличии</span> <?= $balance->qty ?> шт.</p>
            <p class="page-product__price-text">цена за штуку: <span
                        class="page-product__price"><?= isset($good->retailPrice->price) ? ($good->retailPrice->price . ' руб') : 'нет цены' ?></span>

                <?= \app\modules\cart\widgets\CartFormWidget::widget(['goodId' => $good->id]) ?>
        </div>
        <?php if (!empty($good->description) && !empty($good->mainGood->description)) : ?>
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
        <?php endif; ?>
    </div>
    <section class="more-color">
        <h2>Другие цвета пряжи <?= $good->fullName ?></h2>
        <?php foreach ($otherColors as $otherColor) : ?>
            <a class="more-color__item" href="<?= Url::to(['/catalog/default/good', 'id' => $otherColor->id]) ?>">
                <div class="more-color__image-wrapper">
                    <img src="<?= $otherColor->getMainThumbImageUrl() ?>" alt="">
                </div>
                <p class="more-color__color"><?= $otherColor->color ?></p>
            </a>
        <?php endforeach; ?>
    </section>


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