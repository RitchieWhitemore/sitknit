<?php

/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Unit */

$this->title = 'Создать единицу измерения';
$this->params['breadcrumbs'][] = ['label' => 'Единицы измерения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
