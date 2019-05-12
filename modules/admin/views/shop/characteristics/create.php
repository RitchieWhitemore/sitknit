<?php

/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Characteristic */

$this->title = 'Создать характеристику';
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
