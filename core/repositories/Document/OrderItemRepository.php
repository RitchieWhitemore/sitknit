<?php


namespace app\core\repositories\Document;


use app\core\entities\Document\OrderItem;
use app\core\repositories\NotFoundException;

class OrderItemRepository
{
    public function get($documentId, $goodId): OrderItem
    {
        if (!$documentItem = OrderItem::findOne(['document_id' => $documentId, 'good_id' => $goodId])) {
            throw new NotFoundException('Document item is not found.');
        }
        return $documentItem;
    }

    public function find($documentId, $goodId)
    {
        return OrderItem::findOne(['document_id' => $documentId, 'good_id' => $goodId]);
    }

    public function save(OrderItem $documentItem)
    {
        if (!$documentItem->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(OrderItem $documentItem)
    {
        if (!$documentItem->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}