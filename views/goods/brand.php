<?php

use yii\helpers\Url;
use yii\widgets\ListView;

/**
 *
 * @var $brand app\models\Brand
 *
 */
?>
<div class="catalog">
    <h1>Вся пряжа производителя <?= $brand->name ?></h1>
    <p><?=$brand->description?></p>
    <?php echo ListView::widget([
        'dataProvider' => $goodsByNameDataProvider,
        'itemView' => 'block/_goodByNameItem',
        'itemOptions' => ['class' => 'good-by-name__item'],
        'options' => ['class' => 'good-by-name__list'],
        'summary' => ''
    ]);
    ?>
    <?php echo ListView::widget([
        'dataProvider' => $goodsDataProvider,
        'itemView' => 'block/_goodItem',
        'itemOptions' => ['class' => 'catalog__item product'],
        'options' => ['class' => 'catalog__list'],
        'summary' => ''
    ]);
    ?>

</div>
