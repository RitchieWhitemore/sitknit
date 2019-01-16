<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Good */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Вы уверены что хотите удалить эту позицию?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'article',
            'title',
            'description',
            'characteristic',
            [
                'attribute' => 'categoryId',
                'value'     => ArrayHelper::getValue($model, 'category.title'),
            ],
            [
                'attribute' => 'brandId',
                'value'     => ArrayHelper::getValue($model, 'brand.title'),
            ],
            [
                'attribute' => 'countryId',
                'value'     => ArrayHelper::getValue($model, 'country.title'),
            ],
            'packaged',
        ],
    ]) ?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить характеристику', ['attribute-values/create', 'good_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'attribute_id',
                'value'     => 'goodAttribute.name',
            ],
            'value',

            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'attribute-values'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
