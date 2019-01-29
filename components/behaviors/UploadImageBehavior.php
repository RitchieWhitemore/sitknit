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
    public $goodIdField = 'good_id';
    public $catalog;

    /**
     * @var
     *
     *  Значение которое может применять single или multiple
     */
    public $typeSave;

    protected $_goodId;
    protected $_path;
    protected $_serverPath;
    protected $_oldFileName;

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
        $this->_serverPath = Yii::getAlias('@app/web');
    }

    public function beforeValidate()
    {
        $this->imageFile = UploadedFile::getInstance($this->owner, 'imageFile');
    }

    public function afterInsert()
    {
        if ($this->imageFile != null) {
            if ($this->upload()) {
                $this->owner->save(false);
            }
        }
    }

    public function beforeUpdate()
    {
        $this->_oldFileName = $this->owner->getOldAttribute($this->fileNameField);
    }

    public function afterUpdate()
    {
        if ($this->imageFile != null) {
            if ($this->typeSave === 'single') {
                $this->removeOldImage();
            }

            if ($this->upload()) {
                $this->owner->save(false);
            };
        }
    }

    public function beforeDelete()
    {
        return $this->removeOldImage();
    }

    protected function createFileName()
    {
        $id = $this->owner->id;
        if ($this->typeSave == 'multiple') {
            $id = $this->_goodId;
        }

        $fileName = mb_strtolower($this->catalog . '_' . $id . '_' . time());

        $this->owner->{$this->fileNameField} = $fileName . '.' . $this->imageFile->extension;

        return $this->owner->{$this->fileNameField};
    }

    protected function createPathImg()
    {
        $pathBeforeImage = $this->_serverPath . $this->getPathImg();

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
        /**
         *
         * Первая проверка для удаления картинок через Ajax на странице товара
         * Вторая проверка для удаления картинок из категории
         *
         */
        if ($this->_oldFileName === null) {
            $this->_oldFileName = $this->owner->{$this->fileNameField};
        }

        if ($this->_oldFileName === null) {
            return true;
        }

        if (file_exists($this->_serverPath . $this->getPathImg() . $this->_oldFileName)) {
            return unlink($this->_serverPath . $this->getPathImg() . $this->_oldFileName);
        }

        return false;
    }

    public function getMainImageUrl()
    {
        if ($this->owner->{$this->fileNameField}) {
            return $this->_path . '/' . $this->owner->{$this->fileNameField};
        }
    }

}