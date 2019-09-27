<?php

/* @var $this yii\web\View */

use app\core\entities\ItemRemaining;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Остатки';
$this->params['breadcrumbs'][] = $this->title;

\app\modules\admin\assets\DatatableAsset::register($this);
?>
<div class="row m-b-md">
    <div class="col-sm-6">
        <?php if (Yii::$app->request->get('notNull') == true) {
            echo Html::a('Показать все', Url::to(['shop/reports/remaining']), ['class' => 'btn btn-success']);
        } else {
            echo Html::a('Не показывать нулевые остатки', Url::to(['shop/reports/remaining', 'notNull' => true]),
                ['class' => 'btn btn-primary']);
        }
        ?>
    </div>
</div>

<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $remainingActiveProvider,
            'tableOptions' => [
                'class' => 'table table-strip',
                'id' => 'datatable',
            ],
            'options' => [
                'class' => 'table-responsive'
            ],
            'columns' => [
                [
                    'attribute' => 'good',
                    'label' => 'Товар',
                    'value' => function (ItemRemaining $value) {
                        return Html::a($value->good, Url::to(['/admin/shop/goods/view', 'id' => $value->id]));
                    },
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'qty',
                    'label' => 'Кол-во'
                ],
            ]
        ]); ?>
    </div>
</div>
