<?php

use app\core\entities\Document\OrderItem;
use app\core\entities\Document\ReceiptItem;
use app\core\entities\Shop\Good\Value;
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var $this                yii\web\View
 * @var $good                app\core\entities\Shop\Good\Good
 * @var $imagesForm          app\core\forms\manage\Shop\Good\ImagesForm
 * @var $compositionProvider yii\data\ActiveDataProvider
 * @var $pricesProvider      yii\data\ActiveDataProvider
 * @var $siblingGoods        app\core\entities\Shop\Good\Good[]
 */

$this->title = $good->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $good->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $good->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить эту позицию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-body">

            <div class="box box-default">
                <div class="box-header">
                    <h2 class="box-title">Товары с похожим названием</h2>
                </div>
                <ul class="sibling-goods">
                    <?php foreach ($siblingGoods as $good): ?>
                        <li><a href="<?= Url::to([
                                'shop/goods/update',
                                'id' => $good->id
                            ]) ?>">(<?= $good->article ?>
                                ) <?= $good->nameAndColor ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?= DetailView::widget([
                'model' => $good,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'main_good_id',
                        'value' => ArrayHelper::getValue($good, 'mainGood.article'),
                        'label' => 'Артикул товара с которого берутся характеристики',
                    ],

                    'article',
                    'name',
                    [
                        'attribute' => 'category_id',
                        'value' => ArrayHelper::getValue($good, 'category.name'),
                    ],
                    [
                        'attribute' => 'brand_id',
                        'value' => ArrayHelper::getValue($good, 'brand.name'),
                    ],
                    'packaged',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Характеристики</div>
        <div class="box-body">

            <?= DetailView::widget([
                'model' => $good,
                'attributes' => array_map(function (Value $value) {
                    return [
                        'label' => $value->characteristic->name,
                        'value' => $value->value,
                    ];
                }, $good->values),
            ]) ?>
        </div>
    </div>

    <p>
        <?= Html::a('Добавить в состав', [
            'shop/compositions/create',
            'goodId' => $good->id
        ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $compositionProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'material_id',
                'label' => 'Материал',
                'value' => function ($material) {
                    return ArrayHelper::getValue($material, 'material.name');
                }
            ],
            'value',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => '/admin/shop/compositions',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/shop/compositions/update',
                            'goodId' => $model->good_id,
                            'materialId' => $model->material_id
                        ], ['class' => 'glyphicon glyphicon-pencil']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/shop/compositions/delete',
                            'goodId' => $model->good_id,
                            'materialId' => $model->material_id
                        ], ['class' => 'glyphicon glyphicon-trash', 'data-method' => 'post']);
                    }
                ]
            ],
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $pricesProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            'typePrice',
            'price',
        ],
    ])


    ?>

    <div class="box" id="images">
        <div class="box-header with-border">Изображения</div>
        <div class="box-body">

            <div class="row">
                <?php foreach ($good->images as $image): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', [
                                'move-image-up',
                                'id' => $good->id,
                                'image_id' => $image->id
                            ], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', [
                                'delete-image',
                                'id' => $good->id,
                                'image_id' => $image->id
                            ], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove image?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', [
                                'move-image-down',
                                'id' => $good->id,
                                'image_id' => $image->id
                            ], [
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
                'options' => ['enctype' => 'multipart/form-data'],
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

    <div class="box">
        <div class="box-header with-border">Документы</div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $receiptDocumentsProvider,
                'columns' => [
                    [
                        'attribute' => 'document_id',
                        'label' => 'Документ',
                        'value' => function (ReceiptItem $value) {
                            return Html::a('Поступление №' . $value->document_id . ' от ' . $value->document->date,
                                Url::to(['/admin/documents/receipts/view', 'id' => $value->document_id]));
                        },
                        'format' => 'raw'
                    ],
                    'qty',
                ],
            ]) ?>
            <?= GridView::widget([
                'dataProvider' => $orderDocumentsProvider,
                'columns' => [
                    [
                        'attribute' => 'document_id',
                        'label' => 'Документ',
                        'value' => function (OrderItem $value) {
                            return Html::a('Заказ №' . $value->document_id . ' от ' . $value->document->date,
                                Url::to(['/admin/documents/orders/view', 'id' => $value->document_id]));
                        },
                        'format' => 'raw'
                    ],
                    'qty',
                ],
            ]) ?>
        </div>
    </div>


</div>
