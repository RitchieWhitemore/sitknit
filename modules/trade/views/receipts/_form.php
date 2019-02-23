<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

$bundle = \app\assets\WebComponentsAsset::register($this);
$this->registerJsFile("$bundle->baseUrl/partner-selection-form/partner-selection-form.js", ['type' => 'module']);

/* @var $this yii\web\View */
/* @var $model app\modules\trade\models\Receipt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-form">

    <?php $form = ActiveForm::begin(); ?>
    <label>Дата поступления</label>
    <?= DateTimePicker::widget([
        'name' => 'Receipt[date]',
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
        'value' => isset($model->date) ? $model->date : date('Y-m-d H:i', time()),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd HH:ii'
        ]
    ]); ?>

    <partner-selection-form
            label="Контрагент"
            partner-id="<?= $model->partner_id ?>"
            placeholder="Выберите контрагента"
    ><input type="text" name="Receipt[partner_id]" slot="input" hidden></slot></partner-selection-form>

    <?= $form->field($model, 'total')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
