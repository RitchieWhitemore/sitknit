<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trade\models\DocumentItem */

$this->title = 'Редактировать позицию документа: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Позиции документов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="document-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
