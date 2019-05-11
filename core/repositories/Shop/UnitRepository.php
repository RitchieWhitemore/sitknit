<?php


namespace app\core\repositories\Shop;


use app\core\entities\Shop\Unit;
use app\core\repositories\NotFoundException;

class UnitRepository
{
    public function get($id): Unit
    {
        if (!$unit = Unit::findOne($id)) {
            throw new NotFoundException('Unit is not found.');
        }
        return $unit;
    }

    public function save(Unit $unit)
    {
        if (!$unit->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Unit $unit)
    {
        if (!$unit->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}