<?php

namespace app\widgets;

use app\models\Category;
use yii\base\Widget;

class Categories extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $Categories = Category::find()->where(['parent_id' => null])->active()->orderBy('name')->all();

        $Subcategories = [];
        foreach($Categories as $category)
        {
            $Subcategories[$category->id] = Category::find()->where(['parent_id' => $category->id])->active()->orderBy('name')->all();
        }

        return $this->render('categories', [
            'categories' => $Categories,
            'subcategories' => $Subcategories,
        ]);
    }
}