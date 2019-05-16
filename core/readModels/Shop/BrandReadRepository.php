<?php


namespace app\core\readModels\Shop;


use app\core\entities\Shop\Brand;

class BrandReadRepository
{
    public function find($id)
    {
        return Brand::findOne($id);
    }
}