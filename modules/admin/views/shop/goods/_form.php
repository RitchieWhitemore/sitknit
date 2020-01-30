<?php

use app\core\entities\Shop\Brand;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/**
 * @var $this          yii\web\View
 * @var $model         \app\core\forms\manage\Shop\Good\GoodForm
 * @var $siblingGoods  app\core\entities\Shop\Good\Good[]
 * @var $form          yii\widgets\ActiveForm
 *
 * @var $values        app\core\entities\Shop\Characteristic
 *
 */

\app\modules\admin\assets\GoodBackendAsset::register($this);
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
                        ->textInput(['maxlength' => true, 'id' => 'percentInput']) ?>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <p>Оптовая цена установлена на <?= $model->getModel()->getWholesalePriceDate() ?></p>
                        </div>
                        <div class="col-md-5">
                            <p>Розничная цена с наценкой <span id="currentPercent"><?= $model->percent ?></span>% будет
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <p id="wholesalePrice"><?= $model->getModel()->getWholesalePriceString() ?></p>
                        </div>
                        <div class="col-md-5">
                            <p id="retailPrice"><?= $model->getModel()->costRetailPrice() ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($model->getModel()->mainGood) && $model->getModel()->mainGood->id != $model->getModel()->id): ?>
                <div class="row">
                    <div class="col-md-3">
                        У <a href="<?= Url::to(['shop/goods/update', 'id' => $model->getModel()->mainGood->id]) ?>"
                             target="_blank">основного товара</a> установлена наценка: <br>
                        <?= $model->getModel()->mainGood->percent ?>%
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-5">
                                <p>Оптовая цена установлена
                                    на <?= $model->getModel()->mainGood->getWholesalePriceDate() ?></p>
                            </div>
                            <div class="col-md-5">
                                <p>Розничная цена с наценкой <span><?= $model->mainGood->percent ?></span>% будет
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <p><?= $model->getModel()->mainGood->getWholesalePriceString() ?></p>
                            </div>
                            <div class="col-md-5">
                                <p><?= $model->getModel()->mainGood->costRetailPrice() ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
