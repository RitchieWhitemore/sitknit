<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Good\Good;
use app\core\forms\manage\Shop\Good\GoodForm;
use app\core\forms\manage\Shop\Good\ImagesForm;
use app\core\repositories\Shop\BrandRepository;
use app\core\repositories\Shop\CategoryRepository;
use app\core\repositories\Shop\GoodRepository;
use app\core\services\manage\TransactionManager;

class GoodManageService
{
    private $goods;
    private $brands;
    private $categories;
    private $transaction;

    public function __construct(GoodRepository $goods, BrandRepository $brands,
                                CategoryRepository $categories, TransactionManager $transaction)
    {
        $this->goods = $goods;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->transaction = $transaction;
    }

    public function create(GoodForm $form): Good
    {
        $brand = $this->brands->get($form->brand_id);
        $category = $this->categories->get($form->categories->main);

        $good = Good::create(
            $brand->id,
            $category->id,
            $form->article,
            $form->name,
            $form->description,
            $form->packaged,
            $form->main_good_id,
            $form->status);

        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $good->assignCategory($category->id);
        }

        foreach ($form->images->files as $file) {
            $good->addImage($file);
        }

        foreach ($form->values as $value) {
            $good->setValue($value->id, $value->value);
        }

        $this->goods->save($good);
        return $good;
    }

    public function edit($id, GoodForm $form)
    {
        $good = $this->goods->get($id);
        $brand = $this->brands->get($form->brand_id);
        $category = $this->categories->get($form->categories->main);

        $good->edit($brand->id, $form->article, $form->name, $form->description, $form->packaged, $form->main_good_id, $form->status);

        $good->changeMainCategory($category->id);

        $this->transaction->wrap(function () use ($good, $form) {
            $good->revokeCategories();

            $this->goods->save($good);

            foreach ($form->categories->others as $otherId) {
                $category = $this->categories->get($otherId);
                $good->assignCategory($category->id);
            }

            foreach ($form->values as $value) {
                $good->setValue($value->id, $value->value);
            }

            $this->goods->save($good);
        });

    }

    public function remove($id)
    {
        $product = $this->goods->get($id);
        $this->goods->remove($product);
    }

    public function addImages($id, ImagesForm $form)
    {
        $good = $this->goods->get($id);
        foreach ($form->files as $file) {
            $good->addImage($file);
        }
        $this->goods->save($good);
    }

    public function moveImageUp($id, $imageId)
    {
        $good = $this->goods->get($id);
        $good->moveImageUp($imageId);
        $this->goods->save($good);
    }

    public function moveImageDown($id, $imageId)
    {
        $good = $this->goods->get($id);
        $good->moveImageDown($imageId);
        $this->goods->save($good);
    }

    public function removeImage($id, $imageId)
    {
        $good = $this->goods->get($id);
        $good->removeImage($imageId);
        $this->goods->save($good);
    }
}