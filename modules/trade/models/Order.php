<?php

namespace app\modules\trade\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $date
 * @property int $status
 * @property int $payment
 * @property int $partner_id
 * @property double $total
 *
 * @property Partner $partner
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NOT_RESERVE = 0;
    const STATUS_RESERVE = 1;
    const STATUS_SHIPPED = 2;

    const PAYMENT_NOT_PAYMENT = 0;
    const PAYMENT_PAYMENT = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['status', 'partner_id', 'payment'], 'integer'],
            [['total'], 'number'],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['partner_id' => 'id']],
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
            'status' => 'Статус',
            'payment' => 'Оплата',
            'partner_id' => 'Контрагент',
            'total' => 'Сумма',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public function getStatusesArray()
    {
        return [
            self::STATUS_NOT_RESERVE => 'Ожидает подтверждения',
            self::STATUS_RESERVE => 'В резерве',
            self::STATUS_SHIPPED => 'Отгружен',
        ];
    }

    public function getPaymentsArray()
    {
        return [
            self::PAYMENT_NOT_PAYMENT => 'Не оплачен',
            self::PAYMENT_PAYMENT => 'Оплачен',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public function getPaymentName()
    {
        return ArrayHelper::getValue(self::getPaymentsArray(), $this->payment);
    }
}
