<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Брэнды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать брэнд', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([
        'id' => 'brand-list',
        'timeout' => 10000,
        'enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description',
            [
                'attribute'      => 'active',
                'label'          => 'Активен',
                'format'         => 'html',
                'filter'         => [0 => 'нет', 1 => 'да'],
                'contentOptions' => ['class' => 'text-center'],
                'value'          => function ($value) {
                    if ($value->active == 1) {
                        $label = '<span class="glyphicon glyphicon-eye-open text-success"></span>';
                    } else {
                        $label = '<span class="glyphicon glyphicon-eye-close text-success"></span>';
                    }

                    return Html::a($label, ["/admin/brands/toggle-active", "id" => $value->id], ['class' => 'btn-ajax btn-in-view']);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
