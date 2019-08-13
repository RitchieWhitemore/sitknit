<?php

namespace app\modules\trade\models;

use app\core\entities\Document\Order;
use app\core\entities\Document\Receipt;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $name
 * @property string $full_name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $profile
 * @property string $post_index
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
            [['phone'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
            [['full_name', 'address', 'email', 'profile'], 'string', 'max' => 255],
            [['post_index'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Контрагент',
            'full_name' => 'Полное наименование',
            'address' => 'Почтовый адрес',
            'phone' => 'Контактный телефон',
            'email' => 'Email',
            'profile' => 'Профиль в соцсетях',
            'post_index' => 'Почтовый индекс',
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

    public static function getPartnersList()
    {
        return Partner::find()->select(['name', 'id'])
            ->indexBy('id')->orderBy('name')->column();
    }
}
