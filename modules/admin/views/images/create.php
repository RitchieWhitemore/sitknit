<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \app\core\entities\Shop\Good\Image */

$this->title = 'Создать Изображение';
$this->params['breadcrumbs'][] = ['label' => 'Изображения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
