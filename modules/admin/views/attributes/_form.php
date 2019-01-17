<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Unit;

/* @var $this yii\web\View */
/* @var $model app\models\Attribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_id')->dropDownList(Unit::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => 'Выберите единицу измерения']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
