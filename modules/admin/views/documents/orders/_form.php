<?php

use kartik\datetime\DateTimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Document\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-6">
            <label>Дата поступления</label>
            <?= DateTimePicker::widget([
                'name' => 'Order[date]',
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'value' => isset($model->date) ? $model->date : date('Y-m-d H:i', time()),
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd HH:ii'
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'partner_id')
                ->widget(Select2::classname(), [
                    'options' => ['placeholder' => 'Введите название котрагента'],
                    'initValueText' => isset($model->partner)
                        ? $model->partner->name : '',
                    'pluginOptions' => [
                        //'allowClear' => true,
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
                    'pluginEvents' => []
                ]); ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray()) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'payment')->dropDownList($model->getPaymentsArray()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'buttonSave']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
