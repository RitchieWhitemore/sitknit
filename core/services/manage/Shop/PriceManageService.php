<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Document\Receipt;
use app\core\entities\Document\ReceiptItem;
use app\core\entities\Shop\Price;
use app\core\forms\manage\Shop\PriceForm;
use app\core\repositories\Shop\PriceRepository;

class PriceManageService
{
    private $prices;

    public function __construct(PriceRepository $prices)
    {
        $this->prices = $prices;
    }

    public function create(PriceForm $form): Price
    {
        $price = Price::create(
            $form->date,
            $form->type_price,
            $form->price,
            $form->good_id
        );
        $this->prices->save($price);
        return $price;
    }

    public function edit($id, PriceForm $form)
    {
        $price = $this->prices->get($id);

        $price->edit(
            $form->date,
            $form->type_price,
            $form->price,
            $form->good_id
        );
        $this->prices->save($price);
    }

    public function editOldPriceOnDate(Price $price, PriceForm $form)
    {
        $price->edit(
            $form->date,
            $form->type_price,
            $form->price,
            $form->good_id
        );
        $this->prices->save($price);

        return $price;
    }

    public function remove($id)
    {
        $price = $this->prices->get($id);
        $this->prices->remove($price);
    }

    public function setPricesByDocument(Receipt $document)
    {
        foreach ($document->documentItems as $item) {

            $form = new PriceForm();
            $form->type_price = Price::TYPE_PRICE_WHOLESALE;
            $form->price = $item->price;
            $form->good_id = $item->good_id;
            $form->date = $document->date;

            if (!$this->prices->existsPrice($form)) {
                $this->create($form);
            }
        }
    }

    public function setPriceByItemDocument(ReceiptItem $documentItem)
    {
        $form = new PriceForm();
        $form->type_price = Price::TYPE_PRICE_WHOLESALE;
        $form->price = $documentItem->price;
        $form->good_id = $documentItem->good_id;
        $form->date = $documentItem->document->date;

        if (!$this->prices->existsPrice($form)) {
            $this->create($form);
        }
    }
}