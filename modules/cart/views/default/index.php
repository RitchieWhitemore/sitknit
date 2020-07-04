<?php
/**
 * @var $cart \app\modules\cart\models\Cart
 */

use yii\helpers\Html;
use yii\helpers\Url;

\app\modules\cart\widgets\assets\CartAsset::register($this)
?>


<div class="cart">
    <div class="content__title-wrapper">
        <h1 class="content__title">Корзина</h1>
    </div>

    <ul id="cartList" class="cart__list" data-url="<?= Url::to(['/cart/default/edit']) ?>">
        <li class="cart__list-header">
            <div class="cart__list-header-name">
                Наименование
            </div>
            <div class="cart__list-header-qty">
                Кол-во <br><span>(шт)</span>
            </div>
            <div class="cart__list-header-price">
                Цена <br><span>(руб)</span>
            </div>
            <div class="cart__list-header-sum">
                Сумма
            </div>
        </li>
        <?php foreach ($cart->getItems() as $item): ?>
            <li class="cart__item" data-good-id="<?= $item->getId() ?>">
                <div class="cart__item-header">
                    <div class="cart__img-wrapper">
                        <img src="<?= Html::encode($item->good->mainThumbImageUrl) ?>" alt="">
                    </div>
                    <a href="<?= Url::to(['/catalog/default/good', 'id' => $item->getId()]) ?>"><h3
                                class="cart__item-title"><?= $item->good->getNameAndColor() ?></h3></a>
                </div>

                <div class="cart__item-footer">
                    <div class="cart__item-qty qty qty--cart" data-good-id="<?= $item->getId() ?>">
                        <input type="text" class="qty__input" name="qty" placeholder="0" value="<?= $item->qty ?>"/>
                        <button type="button" class="qty__minus">-</button>
                        <button type="button" class="qty__plus">+</button>
                    </div>
                    <div class="cart__item-price"><span class="cart__value-price"><?= $item->getPrice() ?></span> Р<span
                                class="cart__name-column-mobile">Цена</span></div>
                    <div class="cart__item-sum"><span class="cart__value-sum"><?= $item->getSum() ?></span> Р<span
                                class="cart__name-column-mobile">Сумма</span></div>
                    <button class="cart__item-trash" data-good-id="<?= $item->good->id ?>"
                            data-delete-url="<?= Url::to(['/cart/default/delete', 'id' => $item->getId()]) ?>"><i
                                class="far fa-trash-alt"></i></button>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <p class="cart__total">Итого к оплате: <span id="totalSum"><?= $cart->getTotalSum() ?></span> руб.</p>
    <button class="btn btn--cart">Оформить заказ</button>
</div>
