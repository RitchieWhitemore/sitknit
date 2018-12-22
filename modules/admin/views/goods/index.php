<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;
use app\models\Brand;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'filter'    => Category::getCategoriesArray(),
                'attribute' => 'categoryId',
                'value'     => function ($value) {
                    return $value->category->title;
                },
            ],
            [
                'filter'    => Brand::getBrandsArray(),
                'attribute' => 'brandId',
                'value'     => function ($value) {
                    return $value->brand->title;
                },
            ],
            'article',
            'title',
            //'description',
            'characteristic',
            //'countryId',
            //'packaged',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
