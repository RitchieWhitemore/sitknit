<?php

namespace app\modules\trade\models;

use Yii;

use app\modules\trade\models\Order;
use app\models\Good;

/**
 * This is the model class for table "order_item".
 *
 * @property int $order_id
 * @property int $good_id
 * @property int $qty
 * @property double $price
 *
 * @property Good $good
 * @property Order $order
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'good_id', 'qty', 'price'], 'required'],
            [['order_id', 'good_id', 'qty'], 'integer'],
            [['price'], 'number'],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['good_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Заказ №',
            'good_id' => 'Товар',
            'qty' => 'Количество',
            'price' => 'Цена',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['article'] = function () {
            return $this->good->article;
        };
        $fields['article'] = function () {
            return $this->good->article;
        };
        $fields['nameAndColor'] = function () {
            return $this->good->getNameAndColor();
        };


        //unset($fields['good_id']);
        return $fields;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
