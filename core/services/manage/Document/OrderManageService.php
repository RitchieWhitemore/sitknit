<?php


namespace app\core\services\manage\Document;


use app\core\entities\Document\OrderItem;
use app\core\entities\Document\ReceiptItem;
use app\core\forms\manage\Document\OrderItemForm;
use app\core\forms\manage\Document\ReceiptItemForm;
use app\core\repositories\Document\OrderItemRepository;
use app\core\repositories\Document\OrderRepository;
use app\core\repositories\Shop\GoodRepository;

class OrderManageService
{
    private $documents;
    private $documentItems;
    private $goods;

    public function __construct(OrderRepository $documents, OrderItemRepository $documentItems, GoodRepository $goods)
    {
        $this->documents = $documents;
        $this->documentItems = $documentItems;
        $this->goods = $goods;
    }

    public function addItem($document_id, OrderItemForm $form)
    {

        $document = $this->documents->get($document_id);

        /* @var $documentItem OrderItem */
        $documentItem = OrderItem::create($document->id, $form->good_id, $form->qty, $form->price);
        $sort = $document->getDocumentItems()->max('sort');
        $documentItem->sort = $sort + 1;

        $this->documentItems->save($documentItem);

        $document->total = $document->calculateTotalSum();
        $this->documents->save($document);
    }

    public function remove($documentId, $goodId)
    {
        $item = $this->documentItems->get($documentId, $goodId);

        $this->documentItems->remove($item);

        $document = $this->documents->get($documentId);
        $document->total = $document->calculateTotalSum();
        $this->documents->save($document);
    }

    public function editItem(OrderItem $documentItem, OrderItemForm $form)
    {
        $document = $documentItem->document;

        $documentItem->edit($form->good_id, $form->qty, $form->price);

        $this->documentItems->save($documentItem);

        $document->total = $document->calculateTotalSum();
        $this->documents->save($document);
    }

    public function moveItemUp($documentId, $goodId)
    {
        $document = $this->documents->get($documentId);
        $good = $this->goods->get($goodId);
        $document->moveItemUp($document->id, $good->id);
        $this->documents->save($document);
    }

    public function moveItemDown($documentId, $goodId)
    {
        $document = $this->documents->get($documentId);
        $good = $this->goods->get($goodId);
        $document->moveItemDown($document->id, $good->id);
        $this->documents->save($document);
    }
}