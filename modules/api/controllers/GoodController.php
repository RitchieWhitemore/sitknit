<?php

namespace app\modules\api\controllers;

use app\models\Good;
use yii\rest\ActiveController;

class GoodController extends ActiveController
{
    public $modelClass = 'app\models\Good';

    public function actionCategory($category_id)
    {
        if ($category_id == 0) {
            $category_id = null;
        }
        $model = Good::find()->where(['category_id' => (int)$category_id])->limit(10)->all();

        return $model;
    }
}