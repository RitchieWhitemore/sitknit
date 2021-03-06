<?php

use app\core\entities\Shop\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 *
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $category Category
 * @var $list app\core\entities\Shop\Good\Good[]
 *
 */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/catalog']];

if ($category->isComposition()) {
    $yarn = Category::find()->isYarn()->one();
    $this->params['breadcrumbs'][] = [
        'label' => 'Пряжа',
        'url' => Url::to(['catalog/category', 'slug' => $yarn->slug])
    ];
}

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
            $current = $dataProvider->pagination->pageSize
            ?>
            <?php foreach ($values as $value): ?>
                <option value="<?= Html::encode(Url::current(['per-page' => $value])) ?>"
                    <?= $current == $value ? 'selected' : '' ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </label>
</div>

<div class="catalog">
    <h1 class="catalog__title"><?= $category->name ?></h1>
    <p class="catalog__descr"><?= $category->description ?></p>

    <div class="catalog__list dynamic-pager-items">
        <?php foreach ($list as $item): ?>
            <?= $this->render('block/_mainGoodItem', ['model' => $item]) ?>
        <?php endforeach; ?>
    </div>
    <div class='pagination dynamic-paginator'>
        <?= \app\widgets\pagination\LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
    </div>
</div>
