<?php


namespace app\core\forms\manage\Shop;


use app\core\entities\Shop\Good\Good;
use app\core\entities\Shop\Price;
use yii\base\Model;

class PriceForm extends Model
{
    public $date;
    public $type_price;
    public $price;
    public $good_id;

    private $_price;

    public function __construct(Price $price = null, $config = [])
    {
        if ($price) {
            $this->date = $price->date;
            $this->type_price = $price->type_price;
            $this->price = $price->price;
        }
        $this->_price = $price;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['date', 'type_price', 'price', 'good_id'], 'required'],
            [['date'], 'safe'],
            [['type_price', 'good_id'], 'integer'],
            [['price'], 'number'],
            [
                ['good_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Good::className(),
                'targetAttribute' => ['good_id' => 'id']
            ],
        ];
    }
}