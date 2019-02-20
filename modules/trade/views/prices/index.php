<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\trade\models\Price;
use app\models\Good;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trade\models\PriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Цены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать цену', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Установить цены', ['set-prices'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            'date',
            [
                'label'     => 'Товар',
                'attribute' => 'good_id',
                'value'     => 'good.nameAndColor',
            ],
            [
                'filter'    => Price::getTypesPriceArray(),
                'attribute' => 'type_price',
                'value'     => function ($model) {
                    /** @var Price $model */
                    return $model->getTypePrice();
                },
            ],
            'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
