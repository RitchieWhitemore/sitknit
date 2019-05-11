<?php

use app\core\entities\Shop\Unit;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Единицы измерения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index">

    <p>
        <?= Html::a('Создать Единицу измерения', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
             'id',
             [
                 'attribute' => 'name',
                 'value' => function (Unit $model) {
                     return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                 },
                 'format' => 'raw',
             ],
            'full_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
