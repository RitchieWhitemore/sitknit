<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;
use app\models\Brand;
use yii\widgets\Pjax;

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

    <?php Pjax::begin([
            'id' => 'goods-list',
            'timeout' => 10000,
            'enablePushState' => false]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            'article',
            [
                'attribute' => 'category_id',
                'filter'    => Category::getCategoriesArray(),
                'value'     => 'category.name',
            ],
            [

                'attribute' => 'brand_id',
                'filter'    => Brand::getBrandsArray(),
                'value'     => 'brand.name',
            ],

            'name',
            //'description',
            'characteristic',
            //'countryId',
            //'packaged',
            [
                'attribute'      => 'active',
                'label'          => 'Активен',
                'format'         => 'html',
                'filter'         => [0 => 'нет', 1 => 'да'],
                'contentOptions' => ['class' => 'text-center'],
                'value'          => function ($value) {
                    if ($value->active == 1) {
                        $label = '<span class="glyphicon glyphicon-eye-open text-success"></span>';
                    } else {
                        $label = '<span class="glyphicon glyphicon-eye-close text-success"></span>';
                    }

                    return Html::a($label, ["/admin/goods/toggle-active", "id" => $value->id], ['class' => 'btn-ajax btn-in-view']);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
     Pjax::end(); ?>
</div>
