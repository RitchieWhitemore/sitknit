<?php

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Document\Receipt */

$this->title = 'Редактировать поступление товара: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Поступления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="receipt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
