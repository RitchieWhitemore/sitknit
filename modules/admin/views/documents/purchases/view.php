<?php

use app\components\grid\SetColumn;
use app\core\entities\Document\Order;
use app\core\entities\Document\Purchase;
use app\core\entities\Document\Receipt;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\core\entities\Document\Purchase */

$this->title = "Закупка №" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Закупки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="purchase-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'date_start',
                'value' => function (Purchase $model) {
                    return Yii::$app->formatter->asDate($model->date_start);
                }
            ],
        ],
    ]) ?>
    <div class="box">
        <div class="box-header">
            <h3>Поступления товара</h3>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $receipts,
                'tableOptions' => [
                    'class' => 'table table-strip'
                ],
                'options' => [
                    'class' => 'table-responsive'
                ],
                'columns' => [
                    'id',
                    [
                        'attribute' => 'date',
                        'value' => function (Receipt $model) {
                            return Html::a('Поступление № ' . $model->id . ' от ' . Yii::$app->formatter->asDate($model->date,
                                    'php:d-m-Y'),
                                Url::to(['/admin/documents/receipts/view', 'id' => $model->id]),
                                ['target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    'partner.name',
                    'total'
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h3>Заказы клиентов</h3>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $orders,
                'tableOptions' => [
                    'class' => 'table table-strip'
                ],
                'options' => [
                    'class' => 'table-responsive'
                ],
                'columns' => [
                    'id',
                    [
                        'attribute' => 'date',
                        'value' => function (Order $model) {
                            return Html::a('Заказ № ' . $model->id . ' от ' . Yii::$app->formatter->asDate($model->date,
                                    'php:d-m-Y'),
                                Url::to(['/admin/documents/orders/view', 'id' => $model->id]),
                                ['target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    'partner.name',
                    [
                        'class' => SetColumn::className(),
                        'filter' => Order::getStatusesArray(),
                        'attribute' => 'status',
                        'name' => 'statusName',
                        'cssCLasses' => [
                            Order::STATUS_NOT_RESERVE => 'primary',
                            Order::STATUS_RESERVE => 'warning',
                            Order::STATUS_SHIPPED => 'success',
                        ],
                    ],
                    [
                        'class' => SetColumn::className(),
                        'filter' => Order::getPaymentsArray(),
                        'attribute' => 'payment',
                        'name' => 'paymentName',
                        'cssCLasses' => [
                            Order::PAYMENT_NOT_PAYMENT => 'primary',
                            Order::PAYMENT_PAYMENT => 'success',
                        ],
                    ],
                    'total'
                ],
            ]) ?>
        </div>
    </div>


</div>
