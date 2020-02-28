<?php


namespace app\core\services\manage\Document;


use app\core\entities\Document\ReceiptItem;
use app\core\entities\Shop\Price;
use app\core\forms\manage\Document\ReceiptItemForm;
use app\core\repositories\Document\ReceiptItemRepository;
use app\core\repositories\Document\ReceiptRepository;
use app\core\repositories\Shop\GoodRepository;
use app\core\repositories\Shop\PriceRepository;

class ReceiptManageService
{
    private $documents;
    private $documentItems;
    private $goods;
    private $priceRepository;

    public function __construct(
        ReceiptRepository $documents,
        ReceiptItemRepository $documentItems,
        GoodRepository $goods,
        PriceRepository $priceRepository
    ) {
        $this->documents = $documents;
        $this->documentItems = $documentItems;
        $this->goods = $goods;
        $this->priceRepository = $priceRepository;
    }

    public function addItem($document_id, ReceiptItemForm $form)
    {
        /* @var $documentItem ReceiptItem */
        $document = $this->documents->get($document_id);

        $documentItem = ReceiptItem::create($document->id, $form->good_id, $form->qty, $form->price);

        $this->setPrice($document, $form);

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

    public function editItem(ReceiptItem $documentItem, ReceiptItemForm $form)
    {
        $document = $documentItem->document;

        $documentItem->edit($form->good_id, $form->qty, $form->price);

        $this->setPrice($document, $form);

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

    private function setPrice($document, $form)
    {
        $price = $this->priceRepository->getPriceToLastDate(Price::TYPE_PRICE_WHOLESALE, $form->good_id);

        if (!isset($price) || $price->price != $form->price) {
            $price = new Price();
            $price->date = $document->date;
            $price->type_price = Price::TYPE_PRICE_WHOLESALE;
            $price->good_id = $form->good_id;
            $price->price = $form->price;
            $price->save();
        }
    }
}