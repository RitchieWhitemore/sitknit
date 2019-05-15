<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\web\View;

$this->title = 'Приход';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $totalDebitActiveProvider,
            'columns' => [
                'good.nameAndColor',
                'qty'
            ]
        ]); ?>
    </div>
</div>
