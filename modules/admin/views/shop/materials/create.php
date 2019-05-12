<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Material */

$this->title = 'Создать материал';
$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
