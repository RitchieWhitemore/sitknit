<?php


namespace app\core\repositories\Shop;


use app\core\entities\Shop\Characteristic;
use app\core\repositories\NotFoundException;

class CharacteristicRepository
{
    public function get($id): Characteristic
    {
        if (!$characteristic = Characteristic::findOne($id)) {
            throw new NotFoundException('Characteristic is not found.');
        }
        return $characteristic;
    }

    public function save(Characteristic $characteristic)
    {
        if (!$characteristic->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Characteristic $characteristic)
    {
        if (!$characteristic->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}