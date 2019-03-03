<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Composition */

$this->title = 'Создать состав (категорию)';
$this->params['breadcrumbs'][] = ['label' => 'Составы (категории)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="composition-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
