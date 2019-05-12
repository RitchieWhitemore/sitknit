<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Material;
use app\core\forms\manage\Shop\MaterialForm;
use app\core\repositories\Shop\MaterialRepository;

class MaterialManageService
{
    private $materials;

    public function __construct(MaterialRepository $materials)
    {
        $this->materials = $materials;
    }

    public function create(MaterialForm $form): Material
    {
        $material = Material::create(
            $form->name
        );
        $this->materials->save($material);
        return $material;
    }

    public function edit($id, MaterialForm $form)
    {
        $material = $this->materials->get($id);

        $material->edit(
            $form->name
        );
        $this->materials->save($material);
    }

    public function remove($id)
    {
        $material = $this->materials->get($id);
        $this->materials->remove($material);
    }
}