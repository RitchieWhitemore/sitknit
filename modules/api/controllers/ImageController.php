<?php

namespace app\modules\api\controllers;

use app\models\Image;
use Yii;
use yii\rest\ActiveController;
use yii\web\UploadedFile;

class ImageController extends ActiveController
{
    public $modelClass = 'app\models\Image';

    // public $scenario = 'REST';

    public function actionUpload()
    {
        $model = new Image();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->upload()) {
                return 'Картинки успешно загружены';
            }
        }
    }

    public function actionDeleteImage($id)
    {
        $model = Image::findOne($id);
        $currentImageFile = $model->fileName;

        $model->removeOldImage($currentImageFile);
        if ($model->delete()) {
            return "Удалено успешно";
        };
    }

    public function actionToggleMain($id)
    {
        $model = Image::findOne($id);

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            $model->save();
        }
    }

}