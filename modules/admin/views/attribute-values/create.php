<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeValue */

$this->title = 'Создать значение атрибута';
$this->params['breadcrumbs'][] = ['label' => 'Значения атрибутов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
