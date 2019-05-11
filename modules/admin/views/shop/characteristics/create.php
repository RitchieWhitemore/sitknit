<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Characteristic */

$this->title = 'Создать атрибут';
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
