<?php

use yii\widgets\ListView;

/**
 *
 * @var $model app\models\Category
 */

?>

<ul class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i></a> /</li>
    <li><a href="">Пряжа</a> /</li>
    <li>Акриловая пряжа</li>
</ul>

<div class="control">
    <label class="control__label"> Показать по
        <select class="control__dropdown">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15" selected>15</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </label>
</div>
<div class="catalog">
    <h1 class="catalog__title"><?= $model->name ?></h1>
    <p class="catalog__descr"><?= $model->description ?></p>
    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView'     => 'block/_goodItem',
        'itemOptions'  => ['class' => 'catalog__item product'],
        'options'      => ['class' => 'catalog__list'],
    ]);
    ?>
</div>
<div class="pagination">
    <ul class="pagination__list">
        <li class="pagination__item"><a href="" class="link pagination__link">Назад</a></li>
        <li class="pagination__item"><a class="link pagination__link pagination__link--active">1</a></li>
        <li class="pagination__item"><a href="" class="link pagination__link">2</a></li>
        <li class="pagination__item"><a href="" class="link pagination__link">Вперед</a></li>
    </ul>
</div>
