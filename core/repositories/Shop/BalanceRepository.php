<?php


namespace app\core\repositories\Shop;

use app\modules\trade\models\Order;
use app\modules\trade\models\OrderItem;
use app\core\entities\Document\ReceiptItem;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class BalanceRepository
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

        return $balance > 0 ? $balance : 0;
    }

    protected function getTotalQtyDocument(ActiveQuery $query)
    {
        $query = $query->select(['qty'])->where(['good_id' => $this->document->id]);

        if ($query->modelClass == OrderItem::className()) {
            $query->addSelect('order_id')->joinWith('order')->andWhere(['!=', 'order.status', Order::STATUS_NOT_RESERVE]);
        }

        $qtyArray = $query->asArray()->all();

        $totalQtyDocument = array_reduce($qtyArray, function ($carry, $item) {
            return $carry + $item['qty'];
        }, 0);

        return $totalQtyDocument;
    }
}