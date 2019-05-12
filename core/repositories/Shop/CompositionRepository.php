<?php


namespace app\core\repositories\Shop;


use app\core\entities\Shop\Composition;
use app\core\repositories\NotFoundException;

class CompositionRepository
{
    public function get($goodId, $materialId): Composition
    {
        if (!$composition = Composition::findOne([$goodId, $materialId])) {
            throw new NotFoundException('Composition is not found.');
        }
        return $composition;
    }

    public function save(Composition $composition)
    {
        if (!$composition->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Composition $composition)
    {
        if (!$composition->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}