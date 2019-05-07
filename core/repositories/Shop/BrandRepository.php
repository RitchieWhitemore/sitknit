<?php


namespace app\core\repositories\Shop;


use app\core\repositories\NotFoundException;
use app\core\entities\Shop\Brand;
use yii\helpers\FileHelper;

class BrandRepository
{
    public function get($id): Brand
    {
        if (!$brand = Brand::findOne($id)) {
            throw new NotFoundException('Brand is not found.');
        }
        return $brand;
    }

    public function save(Brand $brand)
    {
        if (!$brand->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function removeImage($brand)
    {
        if (!empty($brand->image) && file_exists('img/brand/' . $brand->image)) {
            FileHelper::unlink('img/brand/' . $brand->image);
        }
    }

    public function remove(Brand $brand)
    {
        if (!$brand->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}