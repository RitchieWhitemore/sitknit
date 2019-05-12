<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $good app\core\entities\Shop\Good\Good*/
?>

<div class="composition-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'material_id')->dropDownList($model->materialList()) ?>
            <?= $form->field($model, 'good_id', ['options' => ['style' => 'display:none']])->hiddenInput(['value' => $good->id]); ?>
            <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
