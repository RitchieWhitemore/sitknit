<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CompositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Составы (категории)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="composition-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать состав (категорию)', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([
        'id'              => 'composition-list',
        'timeout'         => 10000,
        'enablePushState' => false]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'image',
                'format'    => 'raw',
                'value'     => function ($value) {
                    return Html::img($value->getMainImageUrl(), ['width' => 100]);
                },
            ],
            'name',
            [
                'attribute'      => 'active',
                'label'          => 'Активен',
                'format'         => 'html',
                'filter'         => [0 => 'нет', 1 => 'да'],
                'contentOptions' => ['class' => 'text-center'],
                'value'          => function ($value) {
                    if ($value->active == 1) {
                        $label = '<span class="glyphicon glyphicon-eye-open text-success"></span>';
                    }
                    else {
                        $label = '<span class="glyphicon glyphicon-eye-close text-success"></span>';
                    }

                    return Html::a($label, ["/admin/compositions/toggle-active", "id" => $value->id], ['class' => 'btn-ajax btn-in-view']);
                },
            ],
            //'content:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
