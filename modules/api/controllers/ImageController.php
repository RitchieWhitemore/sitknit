<?php

namespace app\modules\api\controllers;

use app\core\entities\Shop\Good\Image;
use Yii;
use yii\rest\ActiveController;

class ImageController extends ActiveController
{
    public $modelClass = 'app\core\entities\Shop\Good\Image';

    public function actionToggleMain($id)
    {
        $model = Image::findOne($id);

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            $model->save();
        }
    }

    public function actionDeleteImage($id)
    {
        $model = Image::findOne($id);

        $model->delete();
    }

}