<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $good app\core\entities\Shop\Good\Good */
/* @var $imagesForm app\core\forms\manage\Shop\Good\ImagesForm */

$this->title = $good->name;
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
        <?= Html::a('Редактировать', ['update', 'id' => $good->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $good->id], [
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
                'model'      => $good,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'main_good_id',
                        'value'     => ArrayHelper::getValue($good, 'mainGood.article'),
                        'label'     => 'Артикул товара с которого берутся характеристики',
                    ],

                    'article',
                    'name',
                    [
                        'attribute' => 'category_id',
                        'value'     => ArrayHelper::getValue($good, 'category.name'),
                    ],
                    [
                        'attribute' => 'brand_id',
                        'value'     => ArrayHelper::getValue($good, 'brand.name'),
                    ],
                    'packaged',
                ],
            ]) ?>
        </div>
    </div>

    <p>
        <?= Html::a('Добавить характеристику', [
            'attribute-values/create',
            'good_id' => $good->id
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

    <div class="box" id="images">
        <div class="box-header with-border">Images</div>
        <div class="box-body">

            <div class="row">
                <?php foreach ($good->images as $image): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-image-up', 'id' => $good->id, 'image_id' => $image->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-image', 'id' => $good->id, 'image_id' => $image->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove image?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-image-down', 'id' => $good->id, 'image_id' => $image->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <?= Html::a(
                                Html::img($image->getThumbFileUrl('file_name', 'thumb')),
                                $image->getUploadedFileUrl('file_name'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data'],
            ]); ?>

            <?= $form->field($imagesForm, 'files[]')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


</div>
