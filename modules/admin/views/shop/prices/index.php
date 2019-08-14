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
    <?php if (Yii::$app->request->get('notNull') == true) {
        echo Html::a('Показать все', Url::to(['shop/prices']), ['class' => 'btn btn-success']);
    } else {
        echo Html::a('Не показывать нулевые остатки', Url::to(['shop/prices', 'notNull' => true]),
            ['class' => 'btn btn-primary']);
    }
    ?>
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
                'tableOptions' => [
                    'class' => 'table table-strip'
                ],
                'options'      => [
                    'id'       => 'remaining-table',
                    'data-url' => Url::to(['shop/prices/create-ajax']),
                    'class' => 'table-responsive'
                ],
                'columns'      => [
                    [
                        'attribute' => 'image',
                        'value' => function (ItemRemaining $model) {
                            return $model->image;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 50px'],
                    ],
                    [
                        'label'     => 'Товар',
                        'attribute' => 'good',
                        'value'     => function ($model) {
                            return Html::a($model->good, Url::to([
                                '/admin/shop/goods/view',
                                'id' => $model->id
                            ]), ['target' => '_blank']);
                        },
                        'format' => 'raw',
                        'contentOptions' => [
                            'style' => 'white-space:pre-wrap'
                        ]
                    ],
                    [
                        'attribute' => 'qty',
                        'label' => 'Кол-во'
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
                        'format' => 'raw',
                        'contentOptions' => [
                            'style' => 'white-space:pre-wrap'
                        ]
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
                        'format' => 'raw',
                        'contentOptions' => [
                            'style' => 'white-space:pre-wrap'
                        ]
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
