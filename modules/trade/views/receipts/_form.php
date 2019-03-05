<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

$bundle = \app\assets\WebComponentsAsset::register($this);
$this->registerJsFile("$bundle->baseUrl/partner-selection-form/partner-selection-form.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/document-table/document-table.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/base-choice-form.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/item-element.js", ['type' => 'module']);
/* @var $this yii\web\View */
/* @var $model app\modules\trade\models\Receipt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-6">
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
        </div>
        <div class="col-md-6">
            <base-choice-form label="Контрагент"
                              item-id="<?= $model->partner_id ?>"
                              placeholder="Выберите контрагента"
                              url-api="/api/partners/">
                <h2 slot="title-dialog">Выберите контрагента</h2>
                <input type="text" name="Receipt[partner_id]" slot="input" hidden>
                <item-element id="itemElement" slot="item-element" url-api="/api/partners"></item-element>
            </base-choice-form>
        </div>
    </div>




    <document-table document-id="<?= $model->id ?>" document-type="order"></document-table>

    <?= $form->field($model, 'total')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
