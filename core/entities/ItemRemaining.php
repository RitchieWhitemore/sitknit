<?php


namespace app\core\entities;

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

    public function __construct($item, $reserve = null)
    {
        $this->id = $item->good->id;
        $this->good = $item->good->nameAndColor;
        $this->image = $item->good->getMainImageImg('set_prices');
        $this->wholesalePrice = isset($item->good->wholesalePrice)
            ? $item->good->wholesalePrice->price : 0;
        $this->retailPrice = isset($item->good->retailPrice)
            ? $item->good->retailPrice->price : 0;
        $this->reserve = isset($reserve) ? $reserve->totalQty : null;
    }

    public function setQty($qty)
    {
        $this->qty = $qty;
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