<?php

/**
 * @var $this \yii\web\View
 * @var $order \app\core\entities\Document\Order
 */

$this->title = 'Заказ №' . $order->id;

?>
<div class="breadcrumb">
    <ul class="breadcrumb__list">
        <li class="breadcrumb__item"><a href="/" class="link breadcrumb__link">Главная</a></li>
        <li class="breadcrumb__item"><a href="<?= \yii\helpers\Url::to(['index']) ?>" class="link breadcrumb__link">Кабинет</a>
        </li>
        <li class="breadcrumb__item"><?= $this->title ?></li>
    </ul>
</div>

<div class="content">
    <div class="cabinet__orders">
        <div class="cabinet__orders-title-wrapper">
            <h1 class="cabinet__orders-title cabinet__orders-title--ptsans"><?= $this->title ?></h1>
        </div>

        <div class="table-orders">
            <div class="table-orders__header">
                <div class="table-orders__cell table-orders__order">Товар</div>
                <div class="table-orders__cell">Количество</div>
                <div class="table-orders__cell">Цена</div>
                <div class="table-orders__cell">Сумма</div>
            </div>
            <div class="table-orders__wrapper dynamic-pager-items">
                <?php foreach ($order->documentItems as $item) : ?>
                    <?= $this->render('_order-item', ['model' => $item]) ?>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>