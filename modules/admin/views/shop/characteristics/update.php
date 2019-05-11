<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $characteristic app\core\entities\Shop\Characteristic */
/* @var $model app\core\forms\manage\Shop\CategoryForm */

$this->title = 'Редактирование артибута: ' . $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $characteristic->name, 'url' => ['view', 'id' => $characteristic->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
