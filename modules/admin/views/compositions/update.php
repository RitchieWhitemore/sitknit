<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Shop\Composition */

$this->title = 'Редактировать состав (категорию): ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Составы (категории)', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="composition-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
