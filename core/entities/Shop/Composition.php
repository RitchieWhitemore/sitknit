<?php

namespace app\core\entities\Shop;

use app\core\entities\Shop\Good\Good;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "composition".
 *
 * @property int $good_id
 * @property int $material_id
 * @property string $value
 *
 * @property Material $material
 * @property Good $good
 */
class Composition extends ActiveRecord
{
    public static function create($goodId, $materialId, $value): self
    {
        $composition = new static();
        $composition->good_id = $goodId;
        $composition->material_id = $materialId;
        $composition->value = $value;
        return $composition;
    }

    public function edit($materialId, $value)
    {
        $this->material_id = $materialId;
        $this->value = $value;
    }

    public function isForMaterial($id): bool
    {
        return $this->material_id == $id;
    }

    public static function tableName()
    {
        return '{{%composition}}';
    }

    public function attributeLabels()
    {
        return [
            'material_id' => 'Метериал',
            'value' => 'Значение',
        ];
    }

    public function getMaterial(): ActiveQuery
    {
        return $this->hasOne(Material::class, ['id' => 'material_id']);
    }

    public function getGood(): ActiveQuery
    {
        return $this->hasOne(Good::class, ['id' => 'good_id']);
    }
}
