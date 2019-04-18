<?php


namespace app\components\price;


/**
 * Class StringCsv
 *
 * @property string $number
 * @property string $article
 * @property string $category
 * @property string $brand
 * @property string $name
 * @property string $characteristic
 * @property string $balance
 * @property string $price
 * @property string $package
 *
 * @package app\components\price
 */
class StringCsv
{
    public $number;
    public $article;
    public $category;
    public $brand;
    public $name;
    public $characteristic;
    public $balance;
    public $price;
    public $package;

    public function __construct($item)
    {
        $array = explode('|', $item);

        $this->number = $array['0'];
        $this->article = $array['1'];
        $this->category = $array['2'];
        $this->brand = $array['3'];
        $this->name = $array['4'];
        $this->characteristic = $array['5'];
        $this->balance = $array['7'];
        $this->price = str_replace(',', '.', $array['8']);
        $this->package = $array['9'];

    }

}