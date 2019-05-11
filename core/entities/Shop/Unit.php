<?php

namespace app\core\entities\Shop;

use app\core\entities\Shop\Characteristic;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $name
 * @property string $full_name
 *
 * @property Characteristic[] $characteristics
 */
class Unit extends ActiveRecord
{

    public static function create($name, $fullName): self
    {
        $unit = new static();

        $unit->name = $name;
        $unit->full_name = $fullName;

        return $unit;
    }

    public function edit($name, $fullName)
    {
        $this->name = $name;
        $this->full_name = $fullName;
    }

    public static function tableName()
    {
        return '{{%unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Краткое наименование',
            'full_name' => 'Полное наименование',
        ];
    }

    public function getCharacteristics(): ActiveQuery
    {
        return $this->hasMany(Characteristic::className(), ['unit_id' => 'id']);
    }
}
