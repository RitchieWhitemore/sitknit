<?php

namespace app\modules\trade\models;

use app\core\entities\Shop\Good\Good;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "receipt_item".
 *
 * @property int $receipt_id
 * @property int $good_id
 * @property int $qty
 * @property double $price
 *
 * @property Good $good
 * @property Receipt $receipt
 */
class ReceiptItem extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_id', 'good_id', 'qty', 'price'], 'required'],
            [['receipt_id', 'good_id', 'qty'], 'integer'],
            [['price'], 'number'],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['good_id' => 'id']],
            [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'receipt_id' => 'Приход №',
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
    public function getReceipt()
    {
        return $this->hasOne(Receipt::className(), ['id' => 'receipt_id']);
    }
}
