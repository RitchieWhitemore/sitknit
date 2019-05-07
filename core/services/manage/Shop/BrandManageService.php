<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Brand;
use app\core\forms\manage\Shop\BrandForm;
use app\core\repositories\Shop\BrandRepository;

class BrandManageService
{
    private $brands;

    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    public function create(BrandForm $form): Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            $form->description,
            $form->country_id,
            $form->status
        );

        $brand->image = $form->imageFile;

        $this->brands->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);

        $brand->edit(
            $form->name,
            $form->slug,
            $form->description,
            $form->country_id,
            $form->status
        );

        $brand->image = $form->imageFile;

        $this->brands->save($brand);
    }

    public function remove($id)
    {
        $brand = $this->brands->get($id);

        $this->brands->remove($brand);
    }

}