<?php

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Document\Receipt */

$this->title = 'Создать поступление товара';
$this->params['breadcrumbs'][] = ['label' => 'Поступления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
