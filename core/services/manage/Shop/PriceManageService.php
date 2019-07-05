<?php


namespace app\core\services\manage\Shop;


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
}