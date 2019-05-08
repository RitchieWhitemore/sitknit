<?php

/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Good\Good */

$this->title = 'Создать товар';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="good-create">

    <?= $this->render('_form', [
        'model' => $model,
        'values' => $values,
    ]) ?>

</div>
