<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Shop\Good\Image */

$this->title = 'Редактировать изображение: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
