<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\core\entities\Document\Purchase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-form">
    <div class="box box-default">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <div class="row" style="padding-bottom: 15px">
                <div class="col-md-6">
                    <?= DatePicker::widget([
                        'name' => 'Purchase[date_start]',
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'value' => isset($model->date_start) ? $model->date_start : date('Y-m-d', time()),
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]); ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
