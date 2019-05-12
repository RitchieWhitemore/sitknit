<?php

/* @var $this yii\web\View */
/* @var $model app\core\forms\manage\Shop\CompositionForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $good app\core\entities\Shop\Good\Good*/

$this->title = 'Дабавить материал в состав';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/admin/shop/goods/index']];
$this->params['breadcrumbs'][] = ['label' =>  $good->name, 'url' => ['/admin/shop/goods/view', 'id' => $good->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="composition-form">

    <?= $this->render('_form', [
        'model' => $model,
        'good' => $good
    ]) ?>

</div>

