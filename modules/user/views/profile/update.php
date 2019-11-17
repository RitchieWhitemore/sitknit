<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Обновление профиля пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
        ]); ?>

        <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'middleName')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <? /*= $form->field($model, 'email')->textInput(['maxlength' => true]) */ ?>

        <?php
        if (isset($user->photo)) {
            echo Html::a(
                Html::img($user->getThumbFileUrl('photo', 'admin')),
                $user->getUploadedFileUrl('photo'),
                ['class' => 'thumbnail', 'target' => '_blank']
            );
        } else {
            echo Html::img('/img/no-photo.png', ['width' => 200, 'style' => 'margin-bottom: 25px']);
        }
        ?>

        <?= $form->field($model, 'photo')->fileInput(['accept' => '.jpg, .jpeg, .png']) ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>