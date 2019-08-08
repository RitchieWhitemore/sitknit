<?php

use app\components\grid\SetColumn;
use app\core\entities\Document\Order;
use app\modules\trade\models\Partner;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trade\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'date',
            [
                'attribute' => 'partner_id',
                'filter' => Partner::find()->select(['name', 'id'])
                    ->indexBy('id')->orderBy('name')->column(),
                'label' => 'Контрагент',
                'value' => 'partner.name'
            ],
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
            'total',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
