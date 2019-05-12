<?php

/* @var $this yii\web\View */
/* @var $material app\core\entities\Shop\Material */
/* @var $model app\core\forms\manage\Shop\MaterialForm */

$this->title = 'Редактирование материала: ' . $material->name;
$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $material->name, 'url' => ['view', 'id' => $material->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="material-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
