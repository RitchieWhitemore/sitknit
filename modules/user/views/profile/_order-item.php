<?php

/**
 * @var $model \app\core\entities\Document\OrderItem
 */
?>

<div class="table-orders__row">
    <div class="table-orders__cell table-orders__order"><?= $model->good->getNameAndColor() ?></div>
    <div class="table-orders__cell table-orders__status"><?= $model->qty ?></div>
    <div class="table-orders__cell table-orders__sum"><?= $model->price ?> Р</div>
    <div class="table-orders__cell table-orders__sum"><?= $model->sum ?> Р</div>
</div>
