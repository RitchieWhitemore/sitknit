<?php


namespace app\components;

use app\modules\trade\models\ReceiptItem;

class Balance
{
    public static function currentBalanceOfGood($id)
    {
        $qtyArray = ReceiptItem::find()->select(['qty'])->where(['good_id' => $id])->asArray()->all();

        $balance = array_reduce($qtyArray, function ($carry, $item) {
            return $carry + $item['qty'];
        }, 0);

        return $balance != 0 ? $balance : 'нет в наличии';
    }
}