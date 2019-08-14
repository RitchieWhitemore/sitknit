<?php


namespace app\core\entities;

use app\core\entities\Shop\Good\Good;

/**
 * Class ItemRemaining
 *
 * @property  integer $id
 * @property  Good    $good
 * @property  integer $qty
 */

class ItemRemaining
{
    public $id;
    public $good;
    public $qty;
    public $wholesalePrice;
    public $retailPrice;
    public $image;

    public function __construct($item)
    {
        $this->id = $item->good->id;
        $this->good = $item->good->nameAndColor;
        $this->image = $item->good->getMainImageImg('set_prices');
        $this->wholesalePrice = isset($item->good->wholesalePrice)
            ? $item->good->wholesalePrice->price : 0;
        $this->retailPrice = isset($item->good->retailPrice)
            ? $item->good->retailPrice->price : 0;
    }

    public function setQty($qty)
    {
        $this->qty = $qty;
    }
}