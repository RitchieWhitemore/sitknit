<?php

use app\core\entities\Document\Order;
use app\core\entities\Document\OrderItem;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $document app\core\entities\Document\Order */
/* @var $itemsDataProvider yii\data\ActiveDataProvider */
/* @var $documentTableForm app\core\forms\manage\Document\OrderItemForm */

/* @var $form yii\widgets\ActiveForm */

$this->title = "Заказ покупателя №: $document->id";
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="order-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $document->id],
            ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $document->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $document,
        'attributes' => [
            'id',
            [
                'attribute' => 'date',
                'value' => function (Order $model) {
                    return Yii::$app->formatter->asDate($model->date);
                }
            ],
            [
                'attribute' => 'type',
                'value' => function (Order $model) {
                    return $model->getTypeName();
                }
            ],
            [
                'attribute' => 'status',
                'value' => function (Order $model) {
                    return $model->getStatusName();
                }
            ],
            [
                'attribute' => 'payment',
                'value' => function (Order $model) {
                    return $model->getPaymentName();
                }
            ],
            'partner.name',
            'delivery_cost',
            'packaging_cost',
            'total',
            'comment',
        ],
    ]) ?>

    <?= $this->render('_form-item', [
        'document' => $document,
        'documentTableForm' => $documentTableForm
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $itemsDataProvider,
        'tableOptions' => [
            'class' => 'table table-strip'
        ],
        'options' => [
            'class' => 'table-responsive',
            'style' => 'margin-bottom: 30px',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'value' => function (OrderItem $model) {
                    return
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>',
                            [
                                'move-item-up',
                                'documentId' => $model->document_id,
                                'goodId' => $model->good_id,
                            ], [
                                'data-method' => 'post',
                            ]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>',
                            [
                                'move-item-down',
                                'documentId' => $model->document_id,
                                'goodId' => $model->good_id,
                            ], [
                                'data-method' => 'post',
                            ]);
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align: center; white-space:pre-wrap'],
            ],
            [
                'attribute' => 'good_id',
                'value' => function (OrderItem $model) {
                    return Html::a($model->good->nameAndColor,
                        Url::to(['/admin/shop/goods/view', 'id' => $model->good->id]),
                        ['target' => '_blank']);
                },
                'format' => 'raw',
                'contentOptions' => [
                    'style' => 'white-space:pre-wrap'
                ]
            ],
            'qty',
            [
                'attribute' => 'wholesalePrice',
                'label' => 'Цена закупки',
                'value' => 'good.wholesalePrice.price',
            ],
            'price',
            'sum',
            [
                'attribute' => 'percent',
                'label' => 'Наценка',
                'value' => function (OrderItem $item) {
                    if ($item->good->getWholesalePriceString()) {
                        $calculate = ($item->price - $item->good->getWholesalePriceString()) / $item->good->getWholesalePriceString() * 100;
                        return round($calculate) . '%';
                    }
                    return '-';

                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/documents/orders/item-update',
                            'documentId' => $model->document_id,
                            'goodId' => $model->good_id
                        ], ['class' => 'glyphicon glyphicon-pencil']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/documents/orders/item-delete',
                            'documentId' => $model->document_id,
                            'goodId' => $model->good_id,
                        ], [
                            'class' => 'glyphicon glyphicon-trash',
                            'data-method' => 'post'
                        ]);
                    }
                ]
            ],
        ],
    ]);
    ?>

    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($document, 'delivery_cost')->input('text') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($document, 'packaging_cost')->input('text') ?>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-12">
            <?= $form->field($document, 'comment')->input('text') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
