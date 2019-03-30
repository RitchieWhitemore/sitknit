<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Brand;
use app\models\Category;
use app\models\Composition;

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
$this->registerJsFile("$bundle->baseUrl/choice-form/base-choice-form.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/parent-tree.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/brands-for-choice-form.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/group-good-for-choice-form.js", ['type' => 'module']);
$this->registerJsFile("$bundle->baseUrl/choice-form/item-element.js", ['type' => 'module']);
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

                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-9">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoriesArray(), ['prompt' => 'Выберите категорию']) ?>
                    </div>
                    <div class="col-md-9">
                        <base-choice-form label="Основной товар в группе"
                                          item-id="<?= $model->main_good_id ?>"
                                          category-id="<?= $model->category_id ?>"
                                          placeholder="Выберите основной товар"
                                          url-api="/api/goods/"
                                        model="good">
                            <h2 slot="title-dialog">Выберите основной товар</h2>
                            <input type="text" name="Good[main_good_id]" slot="input" hidden>
                            <parent-tree slot="parent-tree" url-api="/api/categories" item-id="<?=$model->category_id?>"></parent-tree>
                            <brands-for-choice-form slot="brands" url-api="/api/brands" item-id="<?=$model->brand_id?>" category-id="<?=$model->category_id?>"></brands-for-choice-form>
                            <group-good-for-choice-form slot="group-good" url-api="/api/good/group-by-name" category-id="<?=$model->category_id?>" brand-id="<?=$model->brand_id?>"></group-good-for-choice-form>
                            <item-element slot="item-element" url-api="/api/goods"></item-element>
                        </base-choice-form>
                    </div>
                </div>



                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

                <?= $form->field($model, 'characteristic')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'brand_id')->dropDownList(Brand::getBrandsArray(), ['prompt' => 'Выберите брэнд']) ?>

                <?= $form->field($model, 'composition_id')->dropDownList(Composition::getCompositionsArray(), ['prompt' => 'Выберите состав (категорию)']) ?>

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
