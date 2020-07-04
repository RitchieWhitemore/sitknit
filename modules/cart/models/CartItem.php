<?php


namespace app\modules\cart\models;


use app\core\entities\Shop\Good\Good;

class CartItem
{
    public $good;
    public $qty;

    /**
     * CartItem constructor.
     * @param $good
     * @param $qty
     */
    public function __construct(Good $good, $qty)
    {
        $this->good = $good;
        $this->qty = $qty;
    }

    public function getId()
    {
        return $this->good->id;
    }

    public function plusQty($qty)
    {
        return new static($this->good, $this->qty + $qty);
    }

    public function setQty($qty)
    {
        return new static($this->good, $qty);
    }

    public function changeQuantity($qty)
    {
        return new static($this->good, $qty);
    }

    public function getPrice()
    {
        return $this->good->retailPrice->price;
    }

    public function getSum()
    {
        return $this->getPrice() * $this->qty;
    }

}