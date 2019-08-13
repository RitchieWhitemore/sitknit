<?php

/* @var $this yii\web\View */
/* @var $model app\core\entities\Document\Purchase */

$this->title = 'Редактировать закупку: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Закупки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="purchase-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
