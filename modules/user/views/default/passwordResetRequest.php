<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \app\modules\user\models\PasswordResetRequestForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="breadcrumb">
    <ul class="breadcrumb__list">
        <li class="breadcrumb__item"><a href="/" class="link breadcrumb__link">Главная</a></li>
        <li class="breadcrumb__item">Сброс пароля</li>
    </ul>
</div>

<div class="content">
    <div class="content__title-wrapper">
        <h1 class="content__title">Сброс пароля</h1>
    </div>

    <p class="content__descr">введите Ваш email.</p>
    <p style="text-align: center">На него вы получите ссылку для сброса пароля</p>

    <?php $form = ActiveForm::begin([
        'id' => 'request-password-reset-form',
        'options' => ['class' => 'content__form']
    ]); ?>
    <div class="content__fields">
        <?= $form->field($model, 'email')->textInput([
            'placeholder' => 'Ваш email',
            'autofocus' => true
        ])->label('email') ?>
    </div>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn--auth']) ?>
    <?php ActiveForm::end(); ?>
</div>