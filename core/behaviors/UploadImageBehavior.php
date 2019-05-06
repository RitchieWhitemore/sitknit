<?php

namespace app\core\behaviors;

use app\core\helpers\FileHelper;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class UploadImageBehavior
 * @package app\components\behaviors
 *
 * @property ActiveRecord $owner
 *
 */
class UploadImageBehavior extends \yii\base\Behavior
{
    public $path;
    public $attribute;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE   => 'afterDelete',
        ];
    }

    public function beforeUpdate()
    {
        $this->removeOldImage();
    }

    public function afterDelete()
    {
        $this->removeImage();
    }

    private function removeImage()
    {
        FileHelper::removeFile($this->path, $this->owner->{$this->attribute});
    }

    private function removeOldImage()
    {
        FileHelper::removeFile($this->path, $this->owner->oldAttributes[$this->attribute]);
    }

}