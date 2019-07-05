<?php
;

use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/* @var $document app\core\entities\Document\Receipt */
/* @var $documentTableForm app\core\forms\manage\Document\OrderItemForm */

?>
<?php $form = ActiveForm::begin([]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($documentTableForm, 'document_id', ['options' => ['style' => 'display:none']])->hiddenInput(['value' => $document->id]); ?>
            <?= $form->field($documentTableForm, 'good_id')->widget(Select2::classname(), [
                'options'       => ['placeholder' => 'Введите название товара'],
                'initValueText' => isset($documentItem)
                    ? $documentItem->good->nameAndColor : '',
                'pluginOptions' => [
                    //'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language'           => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax'               => [
                        'url'            => '/api/good/list?expand=retailPrice',
                        'dataType'       => 'json',
                        'data'           => new JsExpression('function(params) { return {q:params.term};}'),
                        'processResults' => new JsExpression('function (data) {
                            return {
                                results: data
                            };
                        }'),
                    ],
                    'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                    'templateResult'     => new JsExpression('function(good) { return good.nameAndColor; }'),
                    'templateSelection'  => new JsExpression('function (item) { 
                                                if (item.nameAndColor) {
                                               return item.nameAndColor;
                                               }
                                                return item.text; }'),
                ],
                'pluginEvents'  => [
                    "select2:select" => "function(evt) { 
                        const qtyInput = document.querySelector('#orderitemform-qty');
                        const priceInput = document.querySelector('#orderitemform-price');
                        qtyInput.value = '';
                        qtyInput.focus();
                        priceInput.value = evt.params.data.retailPrice.price;            
                    }",
                ]
            ]); ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($documentTableForm, 'qty')->textInput(['type' => 'number']) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($documentTableForm, 'price')->textInput(['type' => 'double']); ?>
        </div>


    </div>
    <div class="row">
        <div class="col-md-3">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success', 'id' => 'buttonSave']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>