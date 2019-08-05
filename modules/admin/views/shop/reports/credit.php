<?php

/* @var $this yii\web\View */

use dosamigos\chartjs\ChartJs;
use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Расход';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <?= ChartJs::widget([
        'type' => 'pie',
        'id' => 'structurePie',
        'options' => [
            'height' => 400,
            'width' => 400,
        ],
        'data' => [
            'radius' => "90%",
            'labels' => $names, // Your labels
            'datasets' => [
                [
                    'data' => $quantities, // Your dataset
                    'label' => '',
                    'backgroundColor' => $colors,
                    'borderColor' => [
                        '#fff',
                        '#fff',
                        '#fff'
                    ],
                    'borderWidth' => 1,
                    'hoverBorderColor' => ["#999", "#999", "#999"],
                ]
            ]
        ],
        'clientOptions' => [
            'legend' => [
                'display' => false,
                'position' => 'bottom',
                'labels' => [
                    'fontSize' => 14,
                    'fontColor' => "#425062",
                ]
            ],
            'tooltips' => [
                'enabled' => true,
                'intersect' => true
            ],
            'hover' => [
                'mode' => false
            ],
            'maintainAspectRatio' => false,

        ],
    ]);
    ?>
</div>
<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $totalDebitActiveProvider,
            'columns'      => [
                'good.nameAndColor',
                [
                    'attribute' => 'order',
                    'value' => function ($data) {
                        return Html::a(Html::encode($data['document']['id']
                            . " от " . $data['document']['date']), [
                            '/admin/documents/orders/view',
                            'id' => $data['document_id']
                        ]);
                    },
                    'format' => 'raw'
                ],
                'qty'
            ]
        ]); ?>
    </div>
</div>
