<?php

use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use app\core\entities\Shop\Category;

/**
 *
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $category Category
 *
 */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/catalog']];
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
    <h1 class="catalog__title"><?= $category->name ?></h1>
    <p class="catalog__descr"><?= $category->description ?></p>
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
