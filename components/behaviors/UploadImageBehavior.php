<?php

namespace app\components\behaviors;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadImageBehavior extends \yii\base\Behavior
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    protected $_goodId;

    public function upload()
    {
        $fileName = md5($this->imageFile->baseName) . time();
        $this->owner->fileName = $fileName . '.' . $this->imageFile->extension;

        $this->_goodId = $this->owner->goodId;
        if ($this->owner->validate()) {
            if ($this->owner->save()) {
                FileHelper::createDirectory($this->getDirGoodImg());
                $this->imageFile->saveAs($this->getDirGoodImg() . $fileName . '.' . $this->imageFile->extension);
                return true;
            };
            return false;

        }

        return false;
    }

    protected function getDirGoodImg()
    {
        if ($this->_goodId == null) {
            $this->_goodId = $this->owner->goodId;
        }
        return Yii::$app->basePath . '/web/img/product/' . $this->_goodId . '/';
    }

    public function getUrl()
    {
        return Yii::$app->params['dirImageProduct'] . $this->owner->goodId . '/' . $this->owner->fileName;
    }

    public function removeOldImage($fileName)
    {
        if (file_exists($this->getDirGoodImg() . $fileName)) {
            unlink($this->getDirGoodImg() . $fileName);
        }
    }
}