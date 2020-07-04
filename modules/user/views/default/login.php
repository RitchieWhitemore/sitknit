<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\LoginForm */

$this->title = 'Вход на сайт';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="breadcrumb">
    <ul class="breadcrumb__list">
        <li class="breadcrumb__item"><a href="/" class="link breadcrumb__link">Главная</a></li>
        <li class="breadcrumb__item">Вход</li>
    </ul>
</div>

<div class="content">
    <div class="content__title-wrapper">
        <h1 class="content__title">Вход</h1>
    </div>

    <p class="content__descr">введите Ваш логин и пароль</p>

    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'content__form']]); ?>
    <div class="content__fields">
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Ваш email'])->label('email') ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Ваш пароль'])->label('пароль') ?>
        <div class="content__form-footer">
            <div class="checkbox">
                <label class="checkbox__label"><?= Html::checkbox('LoginForm[rememberMe]') ?><span
                            class="checkbox__box"></span>Запомнить меня</label>
            </div>
            <p>Если вы забыли пароль, вы можете <a href="<?= Url::to(['/password-reset-request']) ?>">восстановить</a>
                его</p>
        </div>
    </div>
    <?= Html::submitButton('Войти', ['class' => 'btn btn--auth', 'name' => 'login-button']) ?>
    <?php ActiveForm::end(); ?>
</div>
