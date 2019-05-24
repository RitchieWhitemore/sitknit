<?php


namespace app\core\entities\Document;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Document
 * @package app\core\entities\Document
 *
 *  @property ReceiptItem[]|OrderItem[] $documentItems
 */

abstract class Document extends ActiveRecord
{
    public function moveItemUp($documentId, $goodId)
    {
        $items = $this->documentItems;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($documentId, $goodId)) {
                if ($prev = $items[$i - 1] ?? null) {
                    $items[$i - 1] = $item;
                    $items[$i] = $prev;
                    $this->updateItems($items);
                }
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function moveItemDown($documentId, $goodId)
    {
        $items = $this->documentItems;
        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($documentId, $goodId)) {
                if ($next = $items[$i + 1] ?? null) {
                    $items[$i] = $next;
                    $items[$i + 1] = $item;
                    $this->updateItems($items);
                }
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function calculateTotalSum()
    {
        return $this->getDocumentItems()->sum('sum');
    }

    abstract public function getDocumentItems(): ActiveQuery;

    private function updateItems(array $items)
    {
        foreach ($items as $i => $item) {
            $item->setSort($i);
        }
        $this->documentItems = $items;
    }
}