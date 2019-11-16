<?php

use app\modules\admin\models\User;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <? /*= $form->field($model, 'last_name')->textInput(['maxlength' => true]) */ ?>
    <? /*= $form->field($model, 'first_name')->textInput(['maxlength' => true]) */ ?>
    --><? /*= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) */ ?>

    <?= $form->field($model, 'partner_id')
        ->widget(Select2::classname(), [
            'options' => ['placeholder' => 'Введите название котрагента'],
            'initValueText' => isset($model->partner)
                ? $model->partner->name : '',
            'pluginOptions' => [
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => '/api/partners',
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term};}'),
                    'processResults' => new JsExpression('function (data) {
                            return {
                                results: data
                            };
                        }'),
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(item) { return item.name; }'),
                'templateSelection' => new JsExpression('function (item) { 
                                                if (item.name) {
                                                    return item.name;
                                                }
                                                    return item.text; 
                                                }'),
            ],
        ]); ?>

    <? /*= $form->field($model, 'email')->textInput(['maxlength' => true]) */ ?>

    <?= $form->field($model, 'status')->dropDownList(User::getStatusesArray()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
