<?php

/* @var $this yii\web\View */

use yii\grid\GridView;

$this->title = 'Остатки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">
<?= GridView::widget([
        'dataProvider' => $totalDebitActiveProvider,
        'columns' => [
            'good',
            'qty'
        ]
]); ?>
    </div>
</div>
