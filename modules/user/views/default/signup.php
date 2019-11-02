<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\user\models\SignupForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="breadcrumb">
    <ul class="breadcrumb__list">
        <li class="breadcrumb__item"><a href="/" class="link breadcrumb__link">Главная</a></li>
        <li class="breadcrumb__item">Регистрация</li>
    </ul>
</div>

<div class="content">
    <div class="content__title-wrapper">
        <h1 class="content__title">Регистрация</h1>
    </div>

    <p class="content__descr">пожалуйста, заполните все поля что бы зарегистрироваться:</p>

    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'content__form']]); ?>
    <div class="content__fields">
        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Ваш логин'])->label('') ?>
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Ваш email'])->label('') ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Ваш пароль'])->label('') ?>
        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'captchaAction' => '/user/default/captcha',
            'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6">{input}</div></div>',
        ]) ?>
    </div>
    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn--auth', 'name' => 'signup-button']) ?>
    <?php ActiveForm::end(); ?>
</div>

<div class="user-default-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните все поля что бы зарегистрироваться:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'captchaAction' => '/user/default/captcha',
                'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>