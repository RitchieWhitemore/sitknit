<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
    if (isset($model->fileName)) {
        echo Html::img($model->url, ['width' => 200, 'style' => 'margin-bottom: 25px']);
    }
    ?>

    <?= $form->field($model, 'imageFile')->fileInput(['accept' => '.jpg, .jpeg, .png']) ?>

    <?= $form->field($model, 'goodId')->textInput() ?>

    <?= $form->field($model, 'main')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
