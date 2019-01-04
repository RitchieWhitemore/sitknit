<?php

use yii\helpers\Url;

/**
 *
 * @var $categories \app\models\Category
 * */
?>

<div class="aside-catalog">
    <h2 class="aside-catalog__title">Каталог</h2>
    <div class="aside-catalog__list">
        <?php foreach ($categories as $category) : ?>
            <a class="link aside-catalog__link" href="<?= Url::to(['/goods/category', 'id' => $category->id])?>"><?= $category->title ?> (<?= $category->getGoods()->where(['active' => 1])->count()?>)</a>
        <?php endforeach; ?>
       <!-- <a class="link aside-catalog__link" href="#">Пряжа (1025)</a>

        <a class="link aside-catalog__link aside-catalog__link--active" href="#">Наборы для вязания (259)</a>-->

        <!--<li class="aside-catalog__item"><a class="link aside-catalog__link" href="#">Спицы, крючки, инструменты для вязания (687)</a></li>
        <li class="aside-catalog__item"><a class="link aside-catalog__link" href="#">Фурнитура (54)</a></li>
        <li class="aside-catalog__item"><a class="link aside-catalog__link" href="#">Товары для рукоделия (524)</a></li>
        <li class="aside-catalog__item"><a class="link aside-catalog__link" href="#">Литература (89)</a></li>-->
    </div>
</div>