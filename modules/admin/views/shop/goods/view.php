<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model \app\models\Good */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-view">

    <!--    <ul class="pager">
        <li class="previous">
            <? /*= Html::a('&larr; Предыдущий', ['update', 'id' => $prevId], ['class' => $disablePrev]) */ ?>
        </li>
        <li class="next">
            <? /*= Html::a('Следующий &rarr;', ['update', 'id' => $nextId], ['class' => $disableNext]) */ ?>
        </li>
    </ul>-->

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Вы уверены что хотите удалить эту позицию?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'main_good_id',
                        'value'     => ArrayHelper::getValue($model, 'mainGood.article'),
                        'label'     => 'Артикул товара с которого берутся характеристики',
                    ],

                    'article',
                    'name',
                    [
                        'attribute' => 'category_id',
                        'value'     => ArrayHelper::getValue($model, 'category.name'),
                    ],
                    [
                        'attribute' => 'brand_id',
                        'value'     => ArrayHelper::getValue($model, 'brand.name'),
                    ],
                    'packaged',
                ],
            ]) ?>
        </div>
    </div>

    <p>
        <?= Html::a('Добавить характеристику', [
            'attribute-values/create',
            'good_id' => $model->id
        ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'attribute_id',
                'value'     => 'fullName',
                'label'     => 'Атрибут',
            ],
            [
                'attribute' => 'attributeValues',
                'value'     => function ($value) {
                    return $value->attributeValues[0]->value;
                },
                'label'     => 'Значение',
            ],
            [
                'class'      => 'yii\grid\ActionColumn',
                'controller' => 'attribute-values',
                'buttons'    => [
                    'view'   => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/attribute-values/view',
                            'good_id'      => $model->attributeValues[0]->good_id,
                            'attribute_id' => $model->attributeValues[0]->attribute_id
                        ], ['class' => 'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/attribute-values/update',
                            'good_id'      => $model->attributeValues[0]->good_id,
                            'attribute_id' => $model->attributeValues[0]->attribute_id
                        ], ['class' => 'glyphicon glyphicon-pencil']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/attribute-values/delete',
                            'good_id'      => $model->attributeValues[0]->good_id,
                            'attribute_id' => $model->attributeValues[0]->attribute_id
                        ], ['class' => 'glyphicon glyphicon-trash']);
                    },
                ],
            ],
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $pricesProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            'typePrice',
            'price',
        ],
    ])


    ?>


</div>
