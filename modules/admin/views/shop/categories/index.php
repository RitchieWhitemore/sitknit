<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\core\entities\Shop\Category;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\admin\forms\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box box-default">
        <div class="box-body">
            <?php Pjax::begin([
                'id'              => 'category-list',
                'timeout'         => 10000,
                'enablePushState' => false
            ]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    [
                        'attribute' => 'name',
                        'value'     => function (Category $model) {
                            $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                            return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format'    => 'raw',
                    ],
                    [
                        'value'          => function (Category $model) {
                            return
                                Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', [
                                    'move-up',
                                    'id' => $model->id
                                ]) .
                                Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', [
                                    'move-down',
                                    'id' => $model->id
                                ]);
                        },
                        'format'         => 'raw',
                        'contentOptions' => ['style' => 'text-align: center'],
                    ],
                    [
                        'attribute' => 'image',
                        'format'    => 'raw',
                        'value'     => function ($value) {
                            return Html::a(
                                Html::img($value->getThumbFileUrl('image', 'admin')),
                                $value->getUploadedFileUrl('image'),
                                ['class' => 'thumbnail', 'target' => '_blank']);
                        },
                    ],
                    'slug',
                    [
                        'label'     => 'Кол-во товаров',
                        'attribute' => 'goods_count',
                    ],
                    [
                        'attribute'      => 'status',
                        'label'          => 'Статус',
                        'format'         => 'html',
                        'filter'         => [0 => 'нет', 1 => 'да'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value'          => function ($value) {
                            if ($value->status == 1) {
                                $label = '<span class="glyphicon glyphicon-eye-open text-success"></span>';
                            } else {
                                $label = '<span class="glyphicon glyphicon-eye-close text-success"></span>';
                            }

                            return Html::a($label, [
                                "/admin/shop/categories/toggle-active",
                                "id" => $value->id
                            ], ['class' => 'btn-ajax btn-in-view']);
                        },
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
