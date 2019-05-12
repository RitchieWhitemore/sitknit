<?php

use app\core\entities\Shop\Brand;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\core\entities\Shop\Good\Good
 * @var $form yii\widgets\ActiveForm
 *
 * @var $values app\core\entities\Shop\Characteristic
 *
 */

$this->title = 'Создать товар';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="good-create">

    <?php
    $bundle = \app\assets\WebComponentsAsset::register($this);

    $this->registerJsFile("$bundle->baseUrl/choice-form/base-choice-form.js", ['type' => 'module']);
    $this->registerJsFile("$bundle->baseUrl/choice-form/parent-tree.js", ['type' => 'module']);
    $this->registerJsFile("$bundle->baseUrl/choice-form/brands-for-choice-form.js", ['type' => 'module']);
    $this->registerJsFile("$bundle->baseUrl/choice-form/group-good-for-choice-form.js", ['type' => 'module']);
    $this->registerJsFile("$bundle->baseUrl/choice-form/item-element.js", ['type' => 'module']);
    ?>
    <div class="good-form">
        <div class="box box-default">
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

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="box box-default">
                            <div class="box-header with-border">Категории</div>
                            <div class="box-body">
                                <?= $form->field($model->categories, 'main')->dropDownList($model->categories->categoriesList(), ['prompt' => 'Выберите категорию']) ?>
                                <?= $form->field($model->categories, 'others')->checkboxList($model->categories->categoriesList()) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header with-border">Основной товар в группе</div>
                            <div class="box-body">

                                <base-choice-form label=""
                                                  item-id="<?= $model->main_good_id ?>"
                                                  category-id="<?= $model->category_id ?>"
                                                  placeholder="Выберите основной товар"
                                                  url-api="/api/goods/"
                                                  model="good">
                                    <h2 slot="title-dialog">Выберите основной товар</h2>
                                    <input type="text" name="GoodForm[main_good_id]" slot="input" hidden>
                                    <parent-tree slot="parent-tree" url-api="/api/categories"
                                                 item-id="<?= $model->category_id ?>"></parent-tree>
                                    <brands-for-choice-form slot="brands" url-api="/api/brands"
                                                            item-id="<?= $model->brand_id ?>"
                                                            category-id="<?= $model->category_id ?>"></brands-for-choice-form>
                                    <group-good-for-choice-form slot="group-good"
                                                                url-api="/api/good/group-by-name"
                                                                category-id="<?= $model->category_id ?>"
                                                                brand-id="<?= $model->brand_id ?>"></group-good-for-choice-form>
                                    <item-element slot="item-element" url-api="/api/goods"></item-element>
                                </base-choice-form>
                            </div>
                        </div>
                    </div>
                </div>

                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

                <?= $form->field($model, 'characteristic')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'brand_id')->dropDownList(Brand::getBrandsArray(), ['prompt' => 'Выберите брэнд']) ?>

                <?= $form->field($model, 'packaged')->textInput() ?>

                <?= $form->field($model, 'status')->dropDownList([
                    0 => 'Нет',
                    1 => 'Да'
                ], ['prompt' => 'активируйте товар']) ?>

                <div class="box box-default">
                    <div class="box-header with-border">Характеристики</div>
                    <div class="box-body">
                        <?php foreach ($model->values as $i => $value): ?>
                            <?= $form->field($value, '[' . $i . ']value')->textInput() ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ($this->context->action->id == "create"): ?>
                    <div class="box box-default">
                        <div class="box-header with-border">Изображения</div>
                        <div class="box-body">
                            <?= $form->field($model->images, 'files[]')->widget(FileInput::class, [
                                'options' => [
                                    'accept'   => 'image/*',
                                    'multiple' => true,
                                ]
                            ]) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
