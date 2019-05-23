<?php


namespace app\core\forms\manage\Document;


use app\core\entities\Document\OrderItem;
use app\core\entities\Shop\Good\Good;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class OrderItemForm extends Model
{
    public $document_id;
    public $good_id;
    public $qty;
    public $price;

    private $_item;

    public function __construct(OrderItem $item = null, $config = [])
    {
        if ($item) {
            $this->document_id = $item->document_id;
            $this->good_id = $item->good_id;
            $this->qty = $item->qty;
            $this->price = $item->price;

            $this->_item = $item;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['document_id', 'good_id', 'qty', 'price'], 'required'],
            [['document_id', 'good_id', 'qty'], 'integer'],
            [['price'], 'double'],
            [
                ['good_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Good::className(),
                'targetAttribute' => ['good_id' => 'id']
            ],
            [
                ['document_id', 'good_id'],
                'unique',
                'targetAttribute' => ['document_id', 'good_id'],
                'targetClass'     => OrderItem::class,
                'filter'          => $this->_item ? function ($query) {
                    /* @var $query ActiveQuery */
                    if ($this->_item->good_id != $this->good_id) return false;

                    return $query->andWhere(['<>', 'good_id', $this->good_id])
                        ->andWhere(['<>', 'document_id', $this->document_id]);
                } : null,
                'message'         => 'Такая строка уже есть в таблице'
            ]

        ];
    }

    public function attributeLabels()
    {
        return [
            'good_id' => 'Товар',
            'qty'    => 'Количество',
            'price'  => 'Цена',
        ];
    }

    public function getGoodList()
    {
        $goods = Good::find()->limit(100)->all();

        return ArrayHelper::map($goods, 'id', 'nameAndColor');
    }
}