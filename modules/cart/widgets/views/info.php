<?php

/**
 * @var $amount integer
 * @var $totalSum integer
 */

?>

<div class="page-header__cart-wrapper">
    <img class="page-header__cart" src="/img/header-cart.svg" width="37">
    <div class="page-header__cart-text-wrapper">
        <span class="page-header__cart-quantity"><b>товаров: </b><span id="totalGoodsInfo"><?= $amount ?></span></span>
        <span class="page-header__cart-summ"><b>на сумму: </b><span
                    id="totalSumInfo"><?= $totalSum ?></span> руб.</span>
    </div>
    <a href="#" class="page-header__cart-btn btn">Оформить заказ</a>
</div>
