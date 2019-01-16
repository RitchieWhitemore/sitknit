<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Good */

$this->title = 'Редактировать товар: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="good-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'values' => $values,
        'imagesProvider' => $imagesProvider,
    ]) ?>

</div>
