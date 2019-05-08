<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Good\Good;
use app\core\forms\manage\Shop\Good\GoodForm;
use app\core\repositories\Shop\BrandRepository;
use app\core\repositories\Shop\CategoryRepository;
use app\core\repositories\Shop\GoodRepository;

class GoodManageService
{
    private $goods;
    private $brands;
    private $categories;

    public function __construct(GoodRepository $goods, BrandRepository $brands,
                                CategoryRepository $categories)
    {
        $this->goods = $goods;
        $this->brands = $brands;
        $this->categories = $categories;
    }

    public function create(GoodForm $form): Good
    {
        $brand = $this->brands->get($form->brand_id);
        $category = $this->categories->get($form->category_id);

        $good = Good::create($brand->id, $category->id, $form->article, $form->name, $form->description, $form->packaged, $form->main_good_id, $form->status);

        $this->goods->save($good);
        return $good;
    }

    public function edit($id, GoodForm $form)
    {
        $good = $this->goods->get($id);
        $brand = $this->brands->get($form->brand_id);
        $category = $this->categories->get($form->category_id);

        $good->edit($brand->id, $category->id, $form->article, $form->name, $form->description, $form->packaged, $form->main_good_id, $form->status);

        $this->goods->save($good);
    }

    public function remove($id)
    {
        $product = $this->goods->get($id);
        $this->goods->remove($product);
    }
}