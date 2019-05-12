<?php


namespace app\core\entities\Shop;


use yii\db\ActiveRecord;

/**
 * Class Material
 * @package app\core\entities\Shop
 *
 * @property int $id
 * @property string $name
 *
 */

class Material extends ActiveRecord
{
    public static function create($name): self
    {
        $material = new static();
        $material->name = $name;

        return $material;
    }

    public function edit($name)
    {
        $this->name = $name;
    }
}