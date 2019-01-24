<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 20.01.2019
 * Time: 13:33
 */

namespace app\modules\api\controllers;


use app\models\Category;
use yii\rest\ActiveController;

class CategoryController extends ActiveController
{
    public $modelClass = 'app\models\Category';

    public function actionParent($parent_id)
    {
        if ($parent_id == 0) {
            $parent_id = null;
        }
        $model = Category::find()->where(['parent_id' => $parent_id])->all();

        return $model;
    }
}