<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Shop\Composition */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Составы (категории)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="composition-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'active',
            [
                'attribute' => 'image',
                'format'    => 'raw',
                'value'     => function ($value) {
                    return Html::img($value->url, ['width' => 100]);
                },
            ],
            'content:ntext',
        ],
    ]) ?>

</div>
