<?php

?>

<tr>
    <td class="table-orders__order"><a href="<?= \yii\helpers\Url::to(['/user/profile/order', 'id' => $model->id]) ?>">Заказ
            № <?= $model->id ?> от <?= Yii::$app->formatter->asDate($model->date, 'Y MMM d') ?> г.</a></td>
    <td class="table-orders__status"><?= $model->status ?></td>
    <td class="table-orders__sum"><?= $model->total ?> Р</td>
</tr>
