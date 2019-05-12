<?php


namespace app\core\repositories\Shop;


use app\core\entities\Shop\Good\Good;
use app\core\repositories\NotFoundException;

class GoodRepository
{
    public function get($id): Good
    {
        if (!$good = Good::findOne($id)) {
            throw new NotFoundException('Good is not found');
        }

        return $good;
    }

    public function save(Good $good)
    {
        if (!$good->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Good $good)
    {
        if (!$good->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}