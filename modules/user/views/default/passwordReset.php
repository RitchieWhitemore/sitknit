<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \app\modules\user\models\PasswordResetForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Ввод нового пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="breadcrumb">
    <ul class="breadcrumb__list">
        <li class="breadcrumb__item"><a href="/" class="link breadcrumb__link">Главная</a></li>
        <li class="breadcrumb__item">Ввод нового пароля</li>
    </ul>
</div>

<div class="content">
    <div class="content__title-wrapper">
        <h1 class="content__title">Ввод нового пароля</h1>
    </div>

    <p class="content__descr">Введите новый пароль</p>

    <?php $form = ActiveForm::begin([
        'id' => 'reset-password-form',
        'options' => ['class' => 'content__form']
    ]); ?>
    <div class="content__fields">
        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label('Новый пароль') ?>
    </div>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn--auth']) ?>
    <?php ActiveForm::end(); ?>
</div>