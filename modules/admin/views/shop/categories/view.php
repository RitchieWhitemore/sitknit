<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $category app\core\entities\Shop\Category */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $category->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $category->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Вы действительно хотите удалить эту категорию?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model'      => $category,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'image',
                        'format'    => 'raw',
                        'value'     => function ($value) {
                            /* @var app\core\entities\Shop\Category $value*/
                            return Html::a(
                                Html::img($value->getThumbFileUrl('image', 'admin')),
                                $value->getUploadedFileUrl('image'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            );
                        },
                    ],
                    'name',
                    'slug',
                ],
            ]) ?>
        </div>
    </div>
</div>
