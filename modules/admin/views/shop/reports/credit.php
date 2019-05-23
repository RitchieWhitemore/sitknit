<?php

/* @var $this yii\web\View */

use app\core\entities\Document\Order;
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\web\View;

$this->title = 'Расход';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $totalDebitActiveProvider,
            'columns'      => [
                'good.nameAndColor',
                [
                    'attribute' => 'order',
                    'value' => function ($data) {
                        return Html::a(Html::encode($data['order']['id'] . " от " .$data['order']['date']), ['view', 'id' => $data['order_id']]);
                    },
                    'format' => 'raw'
                ],
                'qty'
            ]
        ]); ?>
    </div>
</div>
