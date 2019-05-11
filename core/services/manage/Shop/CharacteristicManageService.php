<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Characteristic;
use app\core\forms\manage\Shop\CharacteristicForm;
use app\core\repositories\Shop\CharacteristicRepository;
use app\core\repositories\Shop\UnitRepository;

class CharacteristicManageService
{
    private $characteristics;
    private $units;

    public function __construct(CharacteristicRepository $characteristics, UnitRepository $units)
    {
        $this->characteristics = $characteristics;
        $this->units = $units;
    }

    public function create(CharacteristicForm $form): Characteristic
    {
        $characteristic = Characteristic::create(
            $form->name,
            $form->unit_id,
            $form->sort
        );
        $this->characteristics->save($characteristic);
        return $characteristic;
    }

    public function edit($id, CharacteristicForm $form)
    {
        $characteristic = $this->characteristics->get($id);

        $characteristic->edit(
            $form->name,
            $form->unit_id,
            $form->sort
        );
        $this->characteristics->save($characteristic);
    }

    public function remove($id)
    {
        $characteristic = $this->characteristics->get($id);
        $this->characteristics->remove($characteristic);
    }
}