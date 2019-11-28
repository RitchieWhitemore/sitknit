<?php

namespace app\core\entities\Shop;

use app\core\behaviors\TagDependencyBehavior;
use app\core\entities\Shop\Good\Good;
use app\core\entities\Shop\queries\PriceQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string $date
 * @property int $type_price
 * @property double $price
 * @property int $good_id
 *
 * @property Good $good
 */
class Price extends \yii\db\ActiveRecord
{
    const TYPE_PRICE_RETAIL = 0;
    const TYPE_PRICE_WHOLESALE = 1;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TagDependencyBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    public static function create($date, $type, $value, $good_id): self
    {
        $price = new static();
        $price->date = $date;
        $price->type_price = $type;
        $price->price = $value;
        $price->good_id = $good_id;

        return $price;
    }

    public function edit($date, $type, $value, $good_id)
    {
        $this->date = $date;
        $this->type_price = $type;
        $this->price = $value;
        $this->good_id = $good_id;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'type_price' => 'Тип цены',
            'price' => 'Цена',
            'good_id' => 'Товар',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }

    public function getTypePrice()
    {
        return ArrayHelper::getValue(self::getTypesPriceArray(), $this->type_price);
    }

    public static function getTypesPriceArray()
    {
        return [
            self::TYPE_PRICE_RETAIL => 'Розничная',
            self::TYPE_PRICE_WHOLESALE => 'Оптовая',
        ];
    }

    public static function find()
    {
        return new PriceQuery(get_called_class());
    }
}
