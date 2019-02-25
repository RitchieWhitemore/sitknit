<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 16.02.2019
 * Time: 21:38
 */

namespace app\modules\trade\models;


use yii\base\Model;

class SetPriceAjaxForm extends Model
{
    public $date_set_price;
    public $percent_change;
    public $stringCsv;
    public $beginStep;
    public $file_input_price;

    public function rules()
    {
        return [
            [['date_set_price', 'percent_change', 'stringCsv'], 'required'],
            [['percent_change', 'beginStep'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type_price'     => 'Тип цены',
            'percent_change' => 'Процент увеличения цены от оптовой',
        ];
    }
}