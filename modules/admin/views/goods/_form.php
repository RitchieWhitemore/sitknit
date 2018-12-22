<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Brand;
use app\models\Country;

/* @var $this yii\web\View */
/* @var $model app\models\Good */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'characteristic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoryId')->dropDownList(Category::getCategoriesArray()) ?>

    <?= $form->field($model, 'brandId')->dropDownList(Brand::getBrandsArray()) ?>

    <?= $form->field($model, 'countryId')->dropDownList(Country::getCountryArray()) ?>

    <?= $form->field($model, 'packaged')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
