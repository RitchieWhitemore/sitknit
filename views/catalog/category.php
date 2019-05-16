<?php

use yii\helpers\Url;
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
        <select id="input-limit" class="control__dropdown" onchange="location = this.value;">
            <?php
            $values = [15, 25, 50, 75, 100];
            $current = $dataProvider->getPagination()->getPageSize();
            ?>
            <?php foreach ($values as $value): ?>
                <option value="<?= Html::encode(Url::current(['per-page' => $value])) ?>" <?php if ($current == $value): ?>selected="selected"<?php endif; ?>><?= $value ?></option>
            <?php endforeach; ?>
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
