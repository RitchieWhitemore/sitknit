<?php

use app\core\entities\Shop\Category;
use yii\widgets\Breadcrumbs;

/**
 *
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $category Category
 * @var $compositions Category[]
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

<div class="catalog">
    <h1 class="catalog__title"><?= $category->name ?></h1>
    <p class="catalog__descr"><?= $category->description ?></p>
    <div class="catalog__list">
        <?php foreach ($compositions as $item): ?>
            <div class="catalog__item product">
                <?= $this->render('block/_compositionItem', ['model' => $item]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
