<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

$bundle = \app\assets\WebComponentsAsset::register($this);
$this->registerJsFile("$bundle->baseUrl/document-table/document-table.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/base-choice-form.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/selected-modal.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/parent-tree.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/brands-for-choice-form.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/group-good-for-choice-form.js", ['type' => 'module']);
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

    <document-table id="document-table" document-id="<?= $model->id ?>" document-type="order">
        <selected-modal model="selected" slot="button">
            <h2 slot="title-dialog">Выберите товар</h2>
            <parent-tree slot="parent-tree" url-api="/api/categories"></parent-tree>
            <brands-for-choice-form slot="brands" url-api="/api/brands"></brands-for-choice-form>
            <group-good-for-choice-form slot="group-good" url-api="/api/good/group-by-name"></group-good-for-choice-form>
            <item-element slot="item-element" url-api="/api/goods"></item-element>
        </selected-modal>
        <?= $form->field($model, 'total')->textInput(['id' => 'totalSum']) ?>
    </document-table>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'buttonSave']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
