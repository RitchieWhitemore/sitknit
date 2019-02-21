<?php

namespace app\modules\trade\models;

use app\modules\trade\models\Order;
use app\modules\trade\models\Receipt;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $name
 * @property string $full_name
 * @property string $address
 *
 * @property Order[] $orders
 * @property Receipt[] $receipts
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['full_name', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Краткое имя',
            'full_name' => 'Полное имя',
            'address' => 'Адрес',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts()
    {
        return $this->hasMany(Receipt::className(), ['partner_id' => 'id']);
    }
}
