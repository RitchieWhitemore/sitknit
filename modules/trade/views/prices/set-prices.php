<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$bundle = \app\assets\WebComponentsAsset::register($this);

$this->registerJsFile("$bundle->baseUrl/choice-form/choice-form.js", ['type' => 'module']);
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'file_input_price')->fileInput(['accept' => '.csv, .xls', 'class' => 'coll-md-6']) ?>

<div class="form-group">
    <?= Html::submitButton('Установить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
