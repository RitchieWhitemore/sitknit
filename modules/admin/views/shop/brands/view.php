<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model \core\entities\Shop\Brand */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Брэнды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот брэнд?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'image',
                'format'    => 'raw',
                'value'     => function ($value) {
                    /* @var app\core\entities\Shop\Brand $value*/
                    return Html::a(
                        Html::img($value->getThumbFileUrl('image', 'admin')),
                        $value->getUploadedFileUrl('image'),
                        ['class' => 'thumbnail', 'target' => '_blank']
                    );
                },
            ],
            [
                'attribute' => 'country_id',
                'value'     => ArrayHelper::getValue($model, 'country.name'),
            ],
            'description',
        ],
    ]) ?>

</div>
