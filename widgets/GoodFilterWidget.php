<?php


namespace app\widgets;


use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use yii\base\Widget;

class GoodFilterWidget extends Widget
{
    public function run()
    {
        $brands = Brand::find()->active()->all();

        $composition = Category::find()->isComposition()->one();
        $compositions = $composition->getChildren()->all();

        return $this->render('aside-filter', ['brands' => $brands, 'compositions' => $compositions]);
    }
}