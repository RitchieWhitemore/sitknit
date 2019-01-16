<?php

namespace app\components\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class UploadImageBehavior
 * @package app\components\behaviors
 *
 */
class UploadImageBehavior extends \yii\base\Behavior
{
    const IMG_PATH = 'img';
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $fileNameField;
    public $goodIdField = 'goodId';
    public $catalog;

    /**
     * @var
     *
     *  Значение которое может применять single или multiple
     */
    public $typeSave;

    protected $_goodId;
    protected $_currentImageFile;
    protected $_path;
    protected $_new = false;
    protected $_delete = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_AFTER_INSERT    => 'afterInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'afterUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE   => 'beforeDelete',
        ];
    }

    public function init()
    {
        parent::init();

        $this->_path = '/' . self::IMG_PATH . '/' . $this->catalog;
    }

    public function beforeValidate()
    {
        $this->imageFile = UploadedFile::getInstance($this->owner, 'imageFile');
    }

    public function afterInsert()
    {
        if ($this->imageFile != null) {
            if ($this->upload()) {
                $this->_new = true;
                $this->owner->save(false);
            }
        }
    }

    public function beforeUpdate()
    {
        if (!$this->_new) {

        }
    }

    public function afterUpdate()
    {
        if (!$this->_new) {
            if ($this->imageFile != null) {
                if ($this->typeSave === 'multiple') {
                    $this->removeOldImage();
                }

                if ( $this->_delete && $this->upload()) {
                    $this->owner->save(false);
                };
            }
        }
    }

    public function beforeDelete()
    {
        return $this->removeOldImage();
    }

    protected function createFileName()
    {
        $fileName = mb_strtolower($this->catalog . '_' . $this->owner->id);

        $this->owner->{$this->fileNameField} = $fileName . '.' . $this->imageFile->extension;

        if ($this->typeSave == 'multiple') {
            $fileName = md5($this->imageFile->baseName) . time();
            $this->owner->{$this->fileNameField} = $fileName . '.' . $this->imageFile->extension;
        }

        return $this->owner->{$this->fileNameField};
    }

    protected function createPathImg()
    {
        $pathBeforeImage = Yii::$app->basePath . $this->getPathImg();

        FileHelper::createDirectory($pathBeforeImage);

        return $pathBeforeImage;
    }

    public function getPathImg()
    {
        if ($this->typeSave == 'multiple') {
            if ($this->_goodId == null) {
                $this->_goodId = $this->owner->{$this->goodIdField};
            }

            return $this->_path . '/' . $this->_goodId . '/';
        }

        return $this->_path . '/';
    }

    public function getUrl()
    {
        return $this->getPathImg() . $this->owner->{$this->fileNameField};
    }

    public function upload()
    {
        return $this->imageFile->saveAs($this->createPathImg() . $this->createFileName());
    }

    public function removeOldImage()
    {
        if (!$this->_delete) {
            return false;
        }

        $currentImageFile = $this->owner->getOldAttribute($this->fileNameField);

        if ($currentImageFile === null) {
            return false;
        }

        if (file_exists(Yii::$app->basePath . $this->getPathImg() . $currentImageFile)) {
            return unlink(Yii::$app->basePath . $this->getPathImg() . $currentImageFile);
        }

        return false;
    }

    public function getMainImageUrl()
    {
        if ($this->owner->{$this->fileNameField}) {
            return $this->_path . '/' . $this->owner->{$this->fileNameField};
        }
        else {
            return '/img/no-image.svg';
        }
    }

    public function setDeleteFlag($flag = true)
    {
        $this->_delete = $flag;
    }
}