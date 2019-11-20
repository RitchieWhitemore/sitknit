<?php

?>

<a href="<?= \yii\helpers\Url::to(['/user/profile/order', 'id' => $model->id]) ?>" class="table-orders__row">
    <div class="table-orders__cell table-orders__order">Заказ
        № <?= $model->id ?> от <?= Yii::$app->formatter->asDate($model->date, 'Y MMM d') ?> г.
    </div>
    <div class="table-orders__cell table-orders__status"><?= $model->status ?></div>
    <div class="table-orders__cell table-orders__sum"><?= $model->total ?> Р</div>
</a>
