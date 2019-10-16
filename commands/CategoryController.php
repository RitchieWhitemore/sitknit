<?php


namespace app\commands;


use app\core\entities\Shop\Good\CategoryAssignment;
use app\core\entities\Shop\Good\Good;
use yii\console\Controller;

class CategoryController extends Controller
{
    public function actionSetCategoryAssignment()
    {
        foreach (Good::find()->each(100) as $good) {
            /** @var $good Good */
            if (!$category = CategoryAssignment::find()->andWhere([
                'good_id' => $good->id,
                'category_id' => $good->category_id
            ])->one()) {
                $good->assignCategory($good->category_id);
                $good->save();
                echo "For good with id " . $good->id . " assignment category" . PHP_EOL;
            } else {
                echo "found category id " . $category->category_id . ' in good id ' . $good->id . PHP_EOL;
            }


        }
    }
}