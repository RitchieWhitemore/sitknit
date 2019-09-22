<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Остатки';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->request->get('notNull') == true) {
    echo Html::a('Показать все', Url::to(['shop/reports/remaining']), ['class' => 'btn btn-success']);
} else {
    echo Html::a('Не показывать нулевые остатки', Url::to(['shop/reports/remaining', 'notNull' => true]),
        ['class' => 'btn btn-primary']);
}
?>

<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $remainingActiveProvider,
            'tableOptions' => [
                'class' => 'table table-strip'
            ],
            'options' => [
                'class' => 'table-responsive'
            ],
            'columns' => [
                [
                    'attribute' => 'good',
                    'label' => 'Товар'
                ],
                [
                    'attribute' => 'qty',
                    'label' => 'Кол-во'
                ],
            ]
        ]); ?>
    </div>
</div>
