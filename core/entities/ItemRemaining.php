<?php


namespace app\core\entities;

use app\core\entities\Shop\Good\Good;

/**
 * Class ItemRemaining
 *
 * @property  integer $id
 * @property  string $good
 * @property  integer $qty
 */
class ItemRemaining
{
    public $id;
    public $good;
    public $qty;
    public $reserve;
    public $wholesalePrice;
    public $retailPrice;
    public $image;

    public function __construct($id, Good $good)
    {
        $this->id = $id;
        $this->good = $good->nameAndColor;
        $this->image = $good->getMainImageImg('set_prices');
        $this->wholesalePrice = $good->getWholesalePriceString();
        $this->retailPrice = $good->getRetailPriceString();
    }

    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    public function countDifference($creditTotalQty)
    {
        $this->qty = $this->qty - $creditTotalQty;
    }

    public function setReserve($reserveQty)
    {
        $this->reserve = $reserveQty;
    }

    public function isNotNull()
    {
        return $this->qty != 0;
    }

    public function isNull()
    {
        return $this->qty == 0;
    }
}