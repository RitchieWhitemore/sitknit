<?php

namespace app\modules\trade\models;

use app\models\Good;
use Yii;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string $date
 * @property int $type_price
 * @property double $value
 * @property int $good_id
 *
 * @property Good $good
 */
class Price extends \yii\db\ActiveRecord
{
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
}
