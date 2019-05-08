<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Good\Good */

$this->title = 'Редактировать товар: ' . $good->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $good->name, 'url' => ['view', 'id' => $good->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="good-update">

    <?= $this->render('_form', [
        'model' => $model,
        'values' => $values,
        'imagesProvider' => $imagesProvider,
    ]) ?>

</div>
