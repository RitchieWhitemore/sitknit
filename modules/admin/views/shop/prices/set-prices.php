<?php

use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$bundle = \app\assets\WebComponentsAsset::register($this);

$this->registerJsFile("$bundle->baseUrl/parser-excel/parser-excel.js", ['type' => 'module']);
$this->registerJsFile("/js/papaparse.min.js");
?>

<?php if(Yii::$app->session->hasFlash('priceImported')) : ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('priceImported') ?>
    </div>
<?php endif; ?>
<parser-excel session-step="<?= Yii::$app->session->get('countCsv');?>">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <label>Дата установки цены:</label>
            <?= DatePicker::widget([
                'name' => 'SetPriceAjaxForm[date_set_price]',
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
            <?= $form->field($model, 'percent_change')->input('number', ['required' => 'required'])?>
        </div>
    </div>

    <?= $form->field($model, 'file_input_price')->fileInput(['accept' => '.csv', 'class' => 'coll-md-6']) ?>

    <div class="form-group">
        <?= Html::submitButton('Установить', ['class' => 'btn btn-success', 'id' => 'buttonSuccess']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</parser-excel>
