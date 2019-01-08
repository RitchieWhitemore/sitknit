<?php

?>


<h2 class="product__title"><a href="#" class="link">Пряжа <?= $model->title ?></a></h2>
<span class="product__manufacturer"><?= $model->brand->title ?></span>
<div class="product__image-wrapper">
    <img src="<?= $model->getMainImageUrl() ?>">
</div>
<span class="product__color">Розовый (185)</span>
<ul class="product__characteristic-list">
    <li class="product__characteristics-item"><b>Состав:</b>100% полиэстер</li>
    <li class="product__characteristics-item"><b>Вес:</b>100 гр.</li>
    <li class="product__characteristics-item"><b>Длина:</b>95 м.</li>
</ul>
<div class="product__price-wrapper">
    <span class="product__price">151 руб.</span>
</div>

