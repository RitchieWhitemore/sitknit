<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\date\DatePicker;

$bundle = \app\assets\WebComponentsAsset::register($this);

$this->registerJsFile("$bundle->baseUrl/choice-form/choice-form.js", ['type' => 'module']);
?>

<?php if(Yii::$app->session->hasFlash('priceImported')) : ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('priceImported') ?>
    </div>
<?php endif; ?>
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <label>Дата установки цены:</label>
        <?= DatePicker::widget([
            'name' => 'SetPriceForm[date_set_price]',
            'value' => date('Y-m-d', time()),
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'options' => ['placeholder' => 'Выберите дату'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ])?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'percent_change')->input('number')?>
    </div>
</div>

<?= $form->field($model, 'file_input_price')->fileInput(['accept' => '.csv, .xls', 'class' => 'coll-md-6']) ?>

<div class="form-group">
    <?= Html::submitButton('Установить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
