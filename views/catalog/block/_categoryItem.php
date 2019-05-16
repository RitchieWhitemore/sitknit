<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model app\core\entities\Shop\Category
 */
?>


<a href="<?= Url::to(['catalog/category', 'id' => $model->id]) ?>" class="product__link">
    <h2 class="product__title"><?= $model->name ?></h2>
    <div class="product__image-wrapper">
        <img src="<?= Html::encode($model->getThumbFileUrl('image', 'catalog_list')) ?>" alt=""/>
    </div>
    <p class="product__descr"><?= $model->description ?></p>
</a>
