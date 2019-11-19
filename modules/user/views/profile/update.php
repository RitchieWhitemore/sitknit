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
                'class' => 'form'
            ],
        ]); ?>
        <div class="row">
            <div class="col-md-4 col-lg-6">
                <div class="text-center">
                    <?= Html::img($user->getThumbFileUrl('photo', 'avatar_profile', '/img/no-photo.png'),
                        ['width' => 200, 'class' => 'img-circle center-block', 'style' => 'margin-bottom: 25px']); ?>
                </div>
                <?= $form->field($model, 'photo')->fileInput(['accept' => '.jpg, .jpeg, .png']) ?>
            </div>
            <div class="col-md-6 col-lg-6">
                <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'middleName')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            </div>


        </div>
        <div class="row">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary center-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>