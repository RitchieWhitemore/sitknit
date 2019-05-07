<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\core\entities\Shop\Brand */

$this->title = 'Создать брэнд';
$this->params['breadcrumbs'][] = ['label' => 'Брэнды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
