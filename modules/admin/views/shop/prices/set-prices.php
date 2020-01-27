<?php

use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

\app\modules\admin\assets\SetPricesCSVAsset::register($this);
?>

<?php if(Yii::$app->session->hasFlash('priceImported')) : ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('priceImported') ?>
    </div>
<?php endif; ?>
<div>
    <?php $form = ActiveForm::begin([
        'options' => [
            'data-session-step' => Yii::$app->session->get('countCsv', 0)
        ]
    ]); ?>

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

    <div id="messages" class="messages">
        <div id="spinner" class="windows8">
            <div class="wBall" id="wBall_1">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_2">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_3">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_4">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_5">
                <div class="wInnerBall"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Установить', ['class' => 'btn btn-success', 'id' => 'buttonSubmit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

