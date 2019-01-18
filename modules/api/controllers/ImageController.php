<?php

namespace app\modules\api\controllers;

use app\models\Image;
use Yii;
use yii\rest\ActiveController;
use yii\web\UploadedFile;

class ImageController extends ActiveController
{
    public $modelClass = 'app\models\Image';

    public function actionToggleMain($id)
    {
        $model = Image::findOne($id);

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            $model->save();
        }
    }

}