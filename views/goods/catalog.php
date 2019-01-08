<?php

use yii\widgets\ListView;

?>

<div class="catalog">
    <h1 class="catalog__title">Каталог товаров</h1>
    <p class="catalog__descr">В каталоге представленна различная пряжа, а также сопутствующие товары для вязания</p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView'     => 'block/_categoryItem',
        'itemOptions'  => ['class' => 'catalog__item product'],
        'options'      => ['class' => 'catalog__list'],

    ]) ?>
</div>

