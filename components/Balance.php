<?php


namespace app\components;

use app\modules\trade\models\OrderItem;
use app\modules\trade\models\ReceiptItem;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Balance
{
    /**
     * @var ActiveRecord
     *
     */
    protected $document;

    public function __construct(ActiveRecord $document)
    {
        $this->document = $document;
    }

    public function getQty()
    {
        $totalDebit  = $this->getTotalQtyDocument(ReceiptItem::find());
        $totalCredit  = $this->getTotalQtyDocument(OrderItem::find());

        $balance = $totalDebit - $totalCredit;

        return $balance > 0 ? $balance : 'нет в наличии';
    }

    protected function getTotalQtyDocument(ActiveQuery $query)
    {
        $qtyArray = $query->select(['qty'])->where(['good_id' => $this->document->id])->asArray()->all();

        $totalQtyDocument = array_reduce($qtyArray, function ($carry, $item) {
            return $carry + $item['qty'];
        }, 0);

        return $totalQtyDocument;
    }
}