<?php

namespace app\widgets;

use yii\base\Widget;

class Categories extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $Categories = \app\models\Category::findAll(['active' => 1]);

        return $this->render('categories', [
            'categories' => $Categories
        ]);
    }
}