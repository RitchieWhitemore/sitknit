<?php

use app\core\entities\Shop\Brand;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\core\entities\Shop\Country;

/* @var $this yii\web\View */
/* @var $brand app\core\entities\Shop\Brand */
/* @var $model app\core\forms\manage\Shop\BrandForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box">
        <div class="box-body">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'country_id')->dropDownList(Country::getCountryArray(), ['prompt' => 'Выберите страну']) ?>

            <?= $form->field($model, 'status')->dropDownList(Brand::statusList(), ['prompt' => 'Выберите статус']) ?>

            <?php
            if (isset($brand->image)) {
                echo Html::a(
                    Html::img($brand->getThumbFileUrl('image', 'admin')),
                    $brand->getUploadedFileUrl('image'),
                    ['class' => 'thumbnail', 'target' => '_blank']
                );
            } else {
                echo Html::img('/img/no-image.svg', ['width' => 200, 'style' => 'margin-bottom: 25px']);
            }
            ?>

            <?= $form->field($model, 'imageFile')->fileInput(['accept' => '.jpg, .jpeg, .png']) ?>
        </div>
    </div>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

    <?php ActiveForm::end(); ?>

</div>
