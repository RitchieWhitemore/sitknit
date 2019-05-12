<?php


namespace app\core\repositories\Shop;


use app\core\entities\Shop\Material;
use app\core\repositories\NotFoundException;

class MaterialRepository
{
    public function get($id): Material
    {
        if (!$material = Material::findOne($id)) {
            throw new NotFoundException('Material is not found.');
        }
        return $material;
    }

    public function save(Material $material)
    {
        if (!$material->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Material $material)
    {
        if (!$material->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}