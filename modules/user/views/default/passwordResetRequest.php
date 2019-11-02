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
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Ваш email', 'autofocus' => true])->label('') ?>
    </div>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn--auth']) ?>
    <?php ActiveForm::end(); ?>
</div>

<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out your email. A link to reset password will be sent there.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>