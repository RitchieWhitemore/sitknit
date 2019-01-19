<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Brand;
use app\models\Country;

/**
 * @var $this yii\web\View
 * @var $model app\models\Good
 * @var $form yii\widgets\ActiveForm
 *
 * @var $values app\models\Attribute
 *
 */
?>

<div class="good-form">
    <page-tabs>
        <paper-tabs selected="0">
            <paper-tab>Основная информация</paper-tab>
            <paper-tab>Дополнительная информация</paper-tab>
            <?php
            if ($this->context->action->id == "update") {
                echo "<paper-tab>Изображения</paper-tab>";
            }
            ?>
        </paper-tabs>
        <iron-pages selected="0">
            <div>
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'characteristic')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'categoryId')->dropDownList(Category::getCategoriesArray(), ['prompt' => 'Выберите категорию']) ?>

                <?= $form->field($model, 'brandId')->dropDownList(Brand::getBrandsArray(), ['prompt' => 'Выберите брэнд']) ?>

                <?= $form->field($model, 'countryId')->dropDownList(Country::getCountryArray(), ['prompt' => 'Выберите страну']) ?>

                <?= $form->field($model, 'packaged')->textInput() ?>

                <?= $form->field($model, 'active')->dropDownList([0 => 'Нет', 1 => 'Да'], ['prompt' => 'активируйте товар']) ?>
            </div>
            <div>
                <?php foreach ($values as $value): ?>
                    <?= $form->field($value, '[' . $value->goodAttribute->id . ']value')->label($value->goodAttribute->fullName); ?>
                <?php endforeach; ?>
            </div>
            <?php
            if ($this->context->action->id == "update") {
                echo " <div><image-list good-id={$model->id}></image-list></div>";
            }
            ?>
        </iron-pages>
    </page-tabs>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
