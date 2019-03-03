<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Country;

/* @var $this yii\web\View */
/* @var $model app\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->dropDownList(Country::getCountryArray(), ['prompt' => 'Выберите страну']) ?>

    <?= $form->field($model, 'active')->dropDownList([0 => 'Нет', 1 => 'Да'], ['prompt' => 'активируйте брэнд']) ?>

    <?php
    if (isset($model->image)) {
        echo Html::img($model->url, ['width' => 200, 'style' => 'margin-bottom: 25px']);
    } else {
        echo Html::img('/img/no-image.svg', ['width' => 200, 'style' => 'margin-bottom: 25px']);
    }
    ?>

    <?= $form->field($model, 'imageFile')->fileInput(['accept' => '.jpg, .jpeg, .png']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
