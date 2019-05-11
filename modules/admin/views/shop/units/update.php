<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $unit app\core\entities\Shop\Unit */
/* @var $model app\core\forms\manage\Shop\UnitForm */

$this->title = 'Редактировать единицу измерения: ' . $unit->name;
$this->params['breadcrumbs'][] = ['label' => 'Единица измерения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $unit->name, 'url' => ['view', 'id' => $unit->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="unit-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
