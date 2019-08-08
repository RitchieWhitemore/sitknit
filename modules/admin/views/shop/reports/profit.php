<?php

/* @var $this yii\web\View */

use dosamigos\chartjs\ChartJs;

$this->title = 'Прибыль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">
        <?= ChartJs::widget([
            'type' => 'line',
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
                        'data' => $result, // Your dataset
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
</div>