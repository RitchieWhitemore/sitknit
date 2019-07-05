<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\core\entities\Shop\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= DatePicker::widget([
        'name'          => 'Price[date]',
        'value'         => date('Y-m-d', time()),
        'type'          => DatePicker::TYPE_COMPONENT_APPEND,
        'options'       => ['placeholder' => 'Выберите дату'],
        'pluginOptions' => [
            'format'         => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'good_id')->textInput() ?>

    <?= $form->field($model, 'type_price')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
