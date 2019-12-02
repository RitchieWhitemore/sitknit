<?php

/* @var $this yii\web\View */
/* @var $model app\modules\trade\models\Partner */

$this->title = 'Редактировать контрагента: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="partner-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
