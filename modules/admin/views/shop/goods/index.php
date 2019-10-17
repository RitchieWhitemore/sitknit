<?php

use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use app\core\entities\Shop\Good\Good;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\forms\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-index">

    <p>
        <?= Html::a('Создать товар', ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?php Pjax::begin([
                'id' => 'goods-list',
                'timeout' => 10000,
                'enablePushState' => false
            ]);
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'mainImage',
                        'value' => function (Good $model) {
                            return $model->getMainImageImg();
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 100px'],
                    ],
                    'article',
                    [
                        'attribute' => 'category_id',
                        'filter' => Category::getCategoriesArray(),
                        'value' => function (Good $value) {
                            return $value->getCategoriesToString();
                        }
                    ],
                    [

                        'attribute' => 'brand_id',
                        'filter' => Brand::getBrandsArray(),
                        'value' => 'brand.name',
                    ],

                    [
                        'attribute' => 'name',
                        'label' => 'Название',
                        'value' => function (Good $model) {
                            return Html::a(Html::encode($model->nameAndColor),
                                ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Активен',
                        'format' => 'html',
                        'filter' => [0 => 'нет', 1 => 'да'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($value) {
                            if ($value->status == 1) {
                                $label
                                    = '<span class="glyphicon glyphicon-eye-open text-success"></span>';
                            } else {
                                $label
                                    = '<span class="glyphicon glyphicon-eye-close text-success"></span>';
                            }

                            return Html::a($label, [
                                "/admin/shop/goods/toggle-active",
                                "id" => $value->id
                            ], ['class' => 'btn-ajax btn-in-view']);
                        },
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            Pjax::end(); ?>
        </div>
    </div>
</div>
