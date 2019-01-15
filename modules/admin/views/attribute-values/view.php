<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeValue */

$this->title = $model->value;
$this->params['breadcrumbs'][] = ['label' => 'Attribute Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="attribute-value-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'good_id' => $model->good_id, 'attribute_id' => $model->attribute_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'good_id' => $model->good_id, 'attribute_id' => $model->attribute_id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            [
                'attribute' => 'good_id',
                'value'     => ArrayHelper::getValue($model, 'good.title'),
            ],
            [
                'attribute' => 'attribute_id',
                'value'     => ArrayHelper::getValue($model, 'goodAttribute.name'),
            ],

            'value',
        ],
    ]) ?>

</div>
