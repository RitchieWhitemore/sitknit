<?php

use app\core\entities\Shop\Brand;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/**
 * @var $this          yii\web\View
 * @var $model         app\core\entities\Shop\Good\Good
 * @var $siblingGoods  app\core\entities\Shop\Good\Good[]
 * @var $form          yii\widgets\ActiveForm
 *
 * @var $values        app\core\entities\Shop\Characteristic
 *
 */

?>
<div class="good-form box box-default">
    <div class="box-body">
        <div class="box box-default">
            <div class="box-header">
                <h2 class="box-title">Товары с похожим названием</h2>
            </div>
            <ul class="sibling-goods">
                <?php foreach ($siblingGoods as $good): ?>
                    <li><a href="<?= Url::to([
                            'shop/goods/update',
                            'id' => $good->id
                        ]) ?>">(<?= $good->article ?>
                            ) <?= $good->nameAndColor ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'article')
                        ->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-9">
                    <?= $form->field($model, 'name')
                        ->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'percent')
                        ->textInput(['maxlength' => true]) ?>
                </div>

            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="box box-default">
                        <div class="box-body">
                            <?= $form->field($model->categories, 'others')->widget(Select2::className(), [
                                'data' => $model->categories->categoriesList(),
                                'options' => [
                                    'placeholder' => 'Выберите категорию ...',
                                    'multiple' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-body">

                            <?= $form->field($model, 'main_good_id')
                                ->widget(Select2::classname(), [
                                    'options' => ['placeholder' => 'Введите название товара'],
                                    'initValueText' => isset($model->mainGood)
                                        ? $model->mainGood->nameAndColor : '',
                                    'pluginOptions' => [
                                        'minimumInputLength' => 3,
                                        'language' => [
                                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                        ],
                                        'ajax' => [
                                            'url' => '/api/good/list?expand=wholesalePrice',
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term};}'),
                                            'processResults' => new JsExpression('function (data) {
                                                                                                return {
                                                                                                    results: data
                                                                                                };
                                                                                            }'),
                                        ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(good) { return good.nameAndColor; }'),
                                        'templateSelection' => new JsExpression('function (item) { 
                                               if (item.nameAndColor) {
                                               return item.nameAndColor;
                                               }
                                                return item.text;
                                         }'),
                                    ],
                                    'pluginEvents' => []
                                ]); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?= $form->field($model, 'description')
                ->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'characteristic')
                ->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'brand_id')
                ->dropDownList(Brand::getBrandsArray(),
                    ['prompt' => 'Выберите брэнд']) ?>

            <?= $form->field($model, 'packaged')->textInput() ?>

            <?= $form->field($model, 'status')->dropDownList([
                0 => 'Нет',
                1 => 'Да'
            ], ['prompt' => 'активируйте товар']) ?>

            <div class="box box-default">
                <div class="box-header with-border">Характеристики</div>
                <div class="box-body">
                    <?php foreach ($model->values as $i => $value): ?>
                        <?= $form->field($value, '[' . $i . ']value')
                            ->textInput() ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить',
                ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
