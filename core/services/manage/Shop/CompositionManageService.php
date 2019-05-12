<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Composition;
use app\core\forms\manage\Shop\CompositionForm;
use app\core\repositories\Shop\CompositionRepository;
use app\core\repositories\Shop\GoodRepository;
use app\core\repositories\Shop\MaterialRepository;

class CompositionManageService
{
    private $goods;
    private $materials;
    private $compositions;


    public function __construct(GoodRepository $goods, MaterialRepository $materials, CompositionRepository $compositions)
    {
        $this->goods = $goods;
        $this->materials = $materials;
        $this->compositions = $compositions;
    }

    public function create(CompositionForm $form): Composition
    {
        $good = $this->goods->get($form->good_id);
        $material = $this->materials->get($form->material_id);

        $composition = Composition::create(
            $good->id,
            $material->id,
            $form->value
        );
        $this->compositions->save($composition);
        return $composition;
    }

    public function edit($goodId, $materialId, CompositionForm $form)
    {
        $composition = $this->compositions->get($goodId, $materialId);

        $material = $this->materials->get($form->material_id);

        $composition->edit(
            $material->id,
            $form->value
        );
        $this->compositions->save($composition);
    }

    public function remove($goodId, $materialId)
    {
        $composition = $this->compositions->get($goodId, $materialId);
        $this->compositions->remove($composition);
    }
}