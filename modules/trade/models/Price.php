<?php

namespace app\modules\trade\models;

use app\core\entities\Shop\Good\Good;
use app\modules\trade\models\query\PriceQuery;
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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'type_price', 'price', 'good_id'], 'required'],
            [['date'], 'safe'],
            [['type_price', 'good_id'], 'integer'],
            [['price'], 'number'],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['good_id' => 'id']],
        ];
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
