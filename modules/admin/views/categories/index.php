<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([
        'id'              => 'category-list',
        'timeout'         => 10000,
        'enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
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
                'attribute' => 'parent_id',
                'filter'    => Category::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value'     => 'parent.name',
            ],
            [
                'label'     => 'Кол-во товаров',
                'attribute' => 'goods_count',
            ],
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

                    return Html::a($label, ["/admin/categories/toggle-active", "id" => $value->id], ['class' => 'btn-ajax btn-in-view']);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
