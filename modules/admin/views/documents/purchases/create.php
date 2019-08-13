<?php

/* @var $this yii\web\View */
/* @var $model app\core\entities\Document\Purchase */

$this->title = 'Создать закупку';
$this->params['breadcrumbs'][] = ['label' => 'Закупки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
