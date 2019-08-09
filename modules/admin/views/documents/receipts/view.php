<?php

use app\core\entities\Document\ReceiptItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $receipt app\core\entities\Document\Receipt */
/* @var $itemsDataProvider yii\data\ActiveDataProvider */
/* @var $documentTableForm app\core\forms\manage\Document\ReceiptItemForm */


$this->title = "Поступление товаров №: $receipt->id";
$this->params['breadcrumbs'][] = ['label' => 'Поступления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="receipt-view">
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $receipt->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $receipt->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $receipt,
        'attributes' => [
            'id',
            'date',
            'partner.name',
            'total',
        ],
    ]) ?>

    <?= $this->render('_form-item', [
        'receipt'           => $receipt,
        'documentTableForm' => $documentTableForm
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $itemsDataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'value'          => function (ReceiptItem $model) {
                    return
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', [
                            'move-item-up',
                            'documentId' => $model->document_id,
                            'goodId'     => $model->good_id,
                        ], [
                            'data-method' => 'post',
                        ]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', [
                            'move-item-down',
                            'documentId' => $model->document_id,
                            'goodId'     => $model->good_id,
                        ], [
                            'data-method' => 'post',
                        ]);
                },
                'format'         => 'raw',
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            [
                'attribute' => 'good_id',
                'value' => function (ReceiptItem $model) {
                    return Html::a($model->good->nameAndColor,
                        Url::to(['/admin/shop/goods/view', 'id' => $model->good->id]),
                        ['target' => '_blank']);
                },
                'format' => 'raw'
            ],
            'qty',
            'price',
            'sum',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons'  => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/documents/receipts/item-update',
                            'documentId' => $model->document_id,
                            'goodId'     => $model->good_id
                        ], ['class' => 'glyphicon glyphicon-pencil']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', [
                            '/admin/documents/receipts/item-delete',
                            'documentId' => $model->document_id,
                            'goodId'     => $model->good_id,
                        ], ['class' => 'glyphicon glyphicon-trash', 'data-method' => 'post']);
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>
