<?php


namespace app\core\services\manage\Document;


use app\core\entities\Document\ReceiptItem;
use app\core\forms\manage\Document\DocumentTableItemForm;
use app\core\repositories\Document\ReceiptItemRepository;
use app\core\repositories\Document\ReceiptRepository;
use app\core\repositories\Shop\GoodRepository;

class ReceiptManageService
{
    private $documents;
    private $documentItems;
    private $goods;

    public function __construct(ReceiptRepository $documents, ReceiptItemRepository $documentItems, GoodRepository $goods)
    {
        $this->documents = $documents;
        $this->documentItems = $documentItems;
        $this->goods = $goods;
    }

    public function addItem($document_id, DocumentTableItemForm $form)
    {
        /* @var $documentItem ReceiptItem */
        $document = $this->documents->get($document_id);

        $documentItem = ReceiptItem::create($document->id, $form->good_id, $form->qty, $form->price);
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

    public function editItem(ReceiptItem $documentItem, DocumentTableItemForm $form)
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