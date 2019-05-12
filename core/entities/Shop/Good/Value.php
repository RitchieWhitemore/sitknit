<?php

namespace app\core\entities\Shop\Good;

use app\core\entities\Shop\Characteristic;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "value".
 *
 * @property int $good_id
 * @property int $characteristic_id
 * @property string $value
 *
 * @property Characteristic $characteristic
 * @property Good $good
 */
class Value extends ActiveRecord
{
    public static function create($characteristicId, $value): self
    {
        $object = new static();
        $object->characteristic_id = $characteristicId;
        $object->value = $value;
        return $object;
    }

    public static function blank($characteristicId): self
    {
        $object = new static();
        $object->characteristic_id = $characteristicId;
        return $object;
    }

    public function change($value)
    {
        $this->value = $value;
    }

    public function isForCharacteristic($id): bool
    {
        return $this->characteristic_id == $id;
    }

    public static function tableName()
    {
        return '{{%value}}';
    }

    public function attributeLabels()
    {
        return [
            'good_id' => 'Good ID',
            'attribute_id' => 'Атрибут',
            'value' => 'Значение',
        ];
    }

    public function getCharacteristic(): ActiveQuery
    {
        return $this->hasOne(Characteristic::className(), ['id' => 'characteristic_id']);
    }

    public function getGood(): ActiveQuery
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
