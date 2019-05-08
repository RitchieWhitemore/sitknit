<?php

/* @var $this yii\web\View */
/* @var $model app\core\forms\manage\Shop\CategoryForm */
/* @var $category app\core\entities\Shop\Category */

$this->title = 'Редактировать категорию: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model'    => $model,
        'category' => $category,
    ]) ?>

</div>
