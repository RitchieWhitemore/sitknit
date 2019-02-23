<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 16.02.2019
 * Time: 21:38
 */

namespace app\modules\trade\models;


use yii\base\Model;

class SetPriceForm extends Model
{
    public $category_id;
    public $file_price;
    public $file_input_price;
    public $date_set_price;
    public $type_price;
    public $type_price_array = [Price::TYPE_PRICE_RETAIL, Price::TYPE_PRICE_WHOLESALE];

    public $percent_change;

    public $messages;

    public function rules()
    {
        return [
            [['file_input_price', 'date_set_price', 'percent_change'], 'required'],
            [['category_id', 'percent_change'], 'number'],
            [['file_price'], 'file', 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'category_id'    => 'Категория',
            'file_price'     => 'Прайс-лист',
            'type_price'     => 'Тип цены',
            'percent_change' => 'Процент увеличения цены от оптовой',
            'file_input_price' => 'Прайс-лист'
        ];
    }
}