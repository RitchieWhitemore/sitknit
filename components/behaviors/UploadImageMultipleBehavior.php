<?php

namespace app\components\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use yii\web\UploadedFile;

/**
 * Class UploadImageBehavior
 * @package app\components\behaviors
 *
 */
class UploadImageMultipleBehavior extends UploadImageBehavior
{
    /**
     * @var UploadedFile
     */
    public $goodIdField = 'good_id';


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
    }

    public function afterUpdate()
    {
        if ($this->imageFile != null) {

            if ($this->upload()) {
                $this->owner->save(false);
            };
        }
    }

    protected function createFileName()
    {

        $id = $this->_goodId;

        $fileName = mb_strtolower($this->catalog . '_' . $id . '_' . time());

        $this->owner->{$this->fileNameField} = $fileName . '.' . $this->imageFile->extension;

        return $this->owner->{$this->fileNameField};
    }

    public function getPathImg()
    {

        if ($this->_goodId == null) {
            $this->_goodId = $this->owner->{$this->goodIdField};
        }

        return $this->_path . '/' . $this->_goodId . '/';

        return $this->_path . '/';
    }

    public function removeOldImage()
    {
        $filename = $this->_serverPath . $this->getPathImg() . $this->owner->{$this->fileNameField};

        if (file_exists($filename)) {
            return unlink($filename);
        }

        return false;
    }

}