<?php

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Document\Order */

$this->title = 'Создать заказ';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
