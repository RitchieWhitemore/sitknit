<?php

/* @var $this yii\web\View */

use dosamigos\chartjs\ChartJs;

$this->title = 'Прибыль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">
        <?= ChartJs::widget([
            'type' => 'bar',
            'id' => 'bar',
            'options' => [
                'height' => 400,
                'width' => 100,
            ],
            'data' => [
                'labels' => $names, // Your labels
                'datasets' => $datasets
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