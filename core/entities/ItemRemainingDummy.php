<?php


namespace app\core\entities;

/**
 * Class ItemRemaining
 *
 * @property  integer $id
 * @property  string $good
 * @property  integer $qty
 */
class ItemRemainingDummy
{
    public $id;
    public $good;
    public $qty;
    public $image;

    public function __construct()
    {
        $this->qty = 0;
    }
}