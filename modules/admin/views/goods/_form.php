<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
$bundle = \app\assets\WebComponentsAsset::register($this);

$this->registerJsFile("$bundle->baseUrl/page-tabs/page-tabs.js", ['type' => 'module'], $this::POS_END);
$this->registerJsFile("$bundle->baseUrl/page-tabs/page-tabs.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/image-list/image-list.js", ['type' => 'module']);
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

                <? /*$form->field($model, 'category_id')->dropDownList(Category::getCategoriesArray(), ['prompt' => 'Выберите категорию'])*/ ?>
                <choice-form
                        attr="Good[category_id]"
                        label="Категория"
                        model="categories"
                        entity-id="<?= $model->category_id ?>"
                        placeholder="Выберите категорию"
                ></choice-form>

                <!--           --><? /*= $form->field($model, 'main_good_id')->textInput(['maxlength' => true])->label('Id основного товара в группе') */ ?>
                <choice-form
                        attr="Good[main_good_id]"
                        label="Основной товар в группе"
                        model="categories"
                        entity-id="<?= $model->main_good_id ?>"
                        good-id="<?= $model->id ?>"
                        good-flag
                        placeholder="Выберите основной товар"
                ></choice-form>
                <?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

                <?= $form->field($model, 'characteristic')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'brand_id')->dropDownList(Brand::getBrandsArray(), ['prompt' => 'Выберите брэнд']) ?>

                <?= $form->field($model, 'country_id')->dropDownList(Country::getCountryArray(), ['prompt' => 'Выберите страну']) ?>

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
