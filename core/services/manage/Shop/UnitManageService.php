<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Unit;
use app\core\forms\manage\Shop\UnitForm;
use app\core\repositories\Shop\UnitRepository;

class UnitManageService
{
    private $units;

    public function __construct(UnitRepository $units)
    {
        $this->units = $units;
    }

    public function create(UnitForm $form): Unit
    {
        $unit = Unit::create(
            $form->name,
            $form->fullName
        );
        $this->units->save($unit);
        return $unit;
    }

    public function edit($id, UnitForm $form)
    {
        $unit = $this->units->get($id);
        $unit->edit(
            $form->name,
            $form->fullName
        );
        $this->units->save($unit);
    }

    public function remove($id)
    {
        $unit = $this->units->get($id);
        $this->units->remove($unit);
    }
}