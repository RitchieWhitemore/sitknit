<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Attribute;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'good_id')->textInput() ?>

    <?= $form->field($model, 'attribute_id')->dropDownList(Attribute::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => 'Выберите атрибут'] ) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
