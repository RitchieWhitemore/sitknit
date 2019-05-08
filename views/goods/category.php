<?php

use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use app\core\entities\Shop\Category;

/**
 *
 * @var $model \app\core\entities\Shop\Category
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['catalog']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Breadcrumbs::widget([
    'homeLink' => ['label' => 'Главная', 'url' => Yii::$app->homeUrl],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

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

    <?php if ($model->parent == null) {
        echo "<h2>$model->name по производителям:</h2>";
        echo ListView::widget([
            'dataProvider' => $brands,
            'emptyText' => '',
            'itemView' => 'block/_brandItem',
            'itemOptions' => ['class' => 'brand__item'],
            'options' => ['class' => 'brand__list'],
            'summary' => ''
        ]);
    }
    ?>
    <?php
    if ($subcategories->getCount() > 0) {
        echo "<h2>$model->name по составу:</h2>";
        echo ListView::widget([
            'dataProvider' => $subcategories,
            'emptyText' => '',
            'itemView' => 'block/_categoryItem',
            'itemOptions' => ['class' => 'catalog__item product'],
            'options' => ['class' => 'catalog__list'],
            'summary' => ''
        ]);
    }

    ?>
    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'block/_goodItem',
        'itemOptions' => ['class' => 'catalog__item product'],
        'options' => ['class' => 'catalog__list'],
        'layout' => "{items}\n<div class='pagination'>{pager}</div>",
        'pager' => [
            'class' => '\yii\widgets\LinkPager',
            'options' => ['class' => 'pagination__list'],
            'linkContainerOptions' => ['class' => 'pagination__item'],
            'linkOptions' => ['class' => 'link pagination__link'],
            'activePageCssClass' => 'pagination__item--active',
            'nextPageLabel' => 'Вперед',
            'prevPageLabel' => 'Назад',
            'disabledPageCssClass' => 'pagination__item--disabled'
        ]
    ]);
    ?>
</div>
