<?php

namespace app\core\entities\Shop;

use app\core\entities\Shop\Good\Good;
use app\core\entities\Shop\Good\Value;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "characteristic".
 *
 * @property int $id
 * @property string $name
 * @property integer $unit_id
 * @property integer $sort
 *
 * @property Value[] $values
 * @property Good[] $goods
 * @property Unit $unit
 */
class Characteristic extends ActiveRecord
{
    const CHARACTERISTIC_COLOR_ID = 1;

    public static function create($name, $unitId, $sort): Characteristic
    {
        $characteristic = new static();
        $characteristic->name = $name;
        $characteristic->unit_id = $unitId;
        $characteristic->sort = $sort;
        return $characteristic;
    }

    public function edit($name, $unitId, $sort)
    {
        $this->name = $name;
        $this->sort = $sort;
        $this->unit_id = $unitId;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%characteristic}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'unit_id' => 'Единица измерения'
        ];
    }

    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::className(), ['attribute_id' => 'id']);
    }

    public function getGoods(): ActiveQuery
    {
        return $this->hasMany(Good::className(), ['id' => 'good_id'])->viaTable('attribute_value', ['attribute_id' => 'id']);
    }

    public function getUnit(): ActiveQuery
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    public function getFullName()
    {
        $unit = $this->unit ? ' (' . $this->unit->name . ')' : '';
        return $this->name . $unit;
    }
}
