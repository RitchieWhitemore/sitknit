<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Shop\Category */

$this->title = 'Редактировать категорию: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model'    => $model,
        'category' => $category,
    ]) ?>

</div>
