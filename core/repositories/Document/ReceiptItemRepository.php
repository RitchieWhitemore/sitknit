<?php


namespace app\core\repositories\Document;


use app\core\entities\Document\ReceiptItem;
use app\core\repositories\NotFoundException;

class ReceiptItemRepository
{
    public function get($documentId, $goodId): ReceiptItem
    {
        if (!$documentItem = ReceiptItem::findOne(['document_id' => $documentId, 'good_id' => $goodId])) {
            throw new NotFoundException('Document item is not found.');
        }
        return $documentItem;
    }

    public function find($documentId, $goodId)
    {
        return ReceiptItem::findOne(['document_id' => $documentId, 'good_id' => $goodId]);
    }

    public function save(ReceiptItem $documentItem)
    {
        if (!$documentItem->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(ReceiptItem $documentItem)
    {
        if (!$documentItem->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}