<?php


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Создать пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Администрирование пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
