<?php

use app\core\entities\ItemRemaining;
use app\core\entities\Shop\Price;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trade\models\PriceSearch */
/* @var $remainingActiveProvider yii\data\ArrayDataProvider */

\app\modules\admin\assets\SetPricesAsset::register($this);

$this->title = 'Установить цены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-index">
    <div class="box">
        <div class="box-header row">
            <div class="col-sm-6">
                <label class="control-label">Дата установки цены</label>
                <?= DatePicker::widget([
                    'name'          => 'PriceForm[date]',
                    'value'         => date('Y-m-d', time()),
                    'type'          => DatePicker::TYPE_COMPONENT_APPEND,
                    'options'       => [
                        'id'          => 'date-price',
                        'placeholder' => 'Выберите дату'
                    ],
                    'pluginOptions' => [
                        'format'         => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]) ?>
            </div>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $remainingActiveProvider,
                'options'      => [
                    'id'       => 'remaining-table',
                    'data-url' => Url::to(['shop/prices/create-ajax'])
                ],
                'columns'      => [
                    [
                        'label'     => 'Товар',
                        'attribute' => 'good',
                        'value'     => function ($model) {
                            return Html::a($model->good, Url::to([
                                '/admin/shop/goods/view',
                                'id' => $model->id
                            ]), ['target' => '_blank']);
                        },
                        'format'    => 'raw'
                    ],
                    [
                        'attribute' => 'qty',
                        'label'     => 'Количество'
                    ],
                    [
                        'attribute' => 'wholesalePrice',
                        'label'     => 'Закупка',
                        'value'     => function (ItemRemaining $model) {
                            return Html::input('number', 'retail',
                                    $model->wholesalePrice,
                                    ['id' => 'wholesale-price-' . $model->id]
                                )
                                . Html::button('Установить', [
                                    'id'        => 'set-price-' . $model->id,
                                    'data-id'   => $model->id,
                                    'data-name' => 'set-price-button',
                                    'data-type' => Price::TYPE_PRICE_WHOLESALE,
                                ]);
                        },
                        'format'    => 'raw'
                    ],
                    [
                        'label'     => 'Розница',
                        'attribute' => 'retailPrice',
                        'value'     => function (ItemRemaining $model) {
                            return Html::input('number', 'retail',
                                    $model->retailPrice,
                                    ['id' => 'retail-price-' . $model->id]
                                )
                                . Html::button('Установить', [
                                    'id'        => 'set-price-' . $model->id,
                                    'data-id'   => $model->id,
                                    'data-name' => 'set-price-button',
                                    'data-type' => Price::TYPE_PRICE_RETAIL,
                                ]);
                        },
                        'format'    => 'raw'
                    ],
                    [
                        'label'          => "Наценка (%)",
                        'value'          => function (ItemRemaining $model) {
                            if (!$model->wholesalePrice
                                || !$model->retailPrice
                            ) {
                                return '-';
                            }
                            if ($model->retailPrice > 0) {
                                $value = (($model->retailPrice
                                            - $model->wholesalePrice)
                                        / $model->wholesalePrice) * 100;
                                return round($value) . ' %';
                            }
                        },
                        'contentOptions' => function ($model) {
                            return [
                                'id' => 'difference-' . $model->id,
                            ];
                        },
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>
