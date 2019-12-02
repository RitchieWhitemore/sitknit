<?php

/* @var $this yii\web\View */
/* @var $model app\modules\trade\models\Partner */

$this->title = 'Создать контрагента';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
