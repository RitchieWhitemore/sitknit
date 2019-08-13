<?php

use app\core\entities\Document\Order;
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
            'date_start',
        ],
    ]) ?>
    <div class="box">
        <div class="box-header">
            <h3>Поступления товара</h3>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $receipts,
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
                    'total'
                ],
            ]) ?>
        </div>
    </div>


</div>
