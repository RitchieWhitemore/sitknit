<?php

/**
 * @var $model \app\models\Category
 */
?>


<h2 class="product__title"><?= $model->title ?></h2>
<div class="product__image-wrapper">
    <img src="<?= $model->getMainImageUrl()?>" alt="Изображение категории <?= $model->title ?>">
</div>
<p class="product__descr"><?= $model->description ?></p>

