<?php

namespace app\models;

use app\core\entities\Shop\Good\Good;

/**
 * This is the model class for table "attribute_value".
 *
 * @property int $good_id
 * @property int $attribute_id
 * @property string $value
 *
 * @property Attribute $attribute0
 * @property Good $good
 */
class AttributeValue extends \yii\db\ActiveRecord
{
    const SCENARIO_TABULAR = 'tabular';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attribute_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['good_id', 'attribute_id'], 'required'],
            [['value'], 'required', 'except' => self::SCENARIO_TABULAR],
            [['good_id', 'attribute_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['good_id', 'attribute_id'], 'unique', 'targetAttribute' => ['good_id', 'attribute_id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['good_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'good_id' => 'Good ID',
            'attribute_id' => 'Атрибут',
            'value' => 'Значение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodAttribute()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
