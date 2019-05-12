<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Shop\Composition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="composition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList([0 => 'Нет', 1 => 'Да'], ['prompt' => 'активируйте категорию']) ?>

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
