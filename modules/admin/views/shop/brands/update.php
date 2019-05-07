<?php


/* @var $this yii\web\View */
/* @var $model app\core\forms\manage\Shop\BrandForm */
/* @var $brand app\core\entities\Shop\Brand */

$this->title = 'Редактировать брэнд: ' . $brand->name;
$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brand->name, 'url' => ['view', 'id' => $brand->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
        'brand' => $brand,
    ]) ?>

</div>
