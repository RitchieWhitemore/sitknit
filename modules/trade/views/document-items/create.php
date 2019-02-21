<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\trade\models\DocumentItem */

$this->title = 'Создать позицию документа';
$this->params['breadcrumbs'][] = ['label' => 'Позиции документа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
