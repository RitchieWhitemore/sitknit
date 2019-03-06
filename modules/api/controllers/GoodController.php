<?php

namespace app\modules\api\controllers;

use app\models\Good;
use yii\rest\ActiveController;

class GoodController extends ActiveController
{
    public $modelClass = 'app\models\Good';

    public function actionCategory($category_id, $brand_id)
    {
        if ($category_id == 0) {
            $category_id = null;
        }
        if ($brand_id == 0) {
            $brand_id = null;
        }

        $model = Good::find()->where(['category_id' => (int)$category_id, 'brand_id' => (int)$brand_id])->all();

        return $model;
    }

    public function actionDeleteMainGood($id)
    {
        $model = Good::findOne($id);
        $model->main_good_id = null;
    }
}