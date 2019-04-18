<?php



namespace app\modules\trade\models;


use yii\base\Model;

/**
 *
 * @property string $stringPackCsv
 * @property int $percent_change
 *
 */
class SetPriceAjaxForm extends Model
{
    public $date_set_price;
    public $percent_change;
    public $stringPackCsv;
    public $beginStep;
    public $file_input_price;

    public function rules()
    {
        return [
            [['date_set_price', 'percent_change', 'stringPackCsv'], 'required'],
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