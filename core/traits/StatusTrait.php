<?php


namespace app\core\traits;

use yii\helpers\ArrayHelper;

trait StatusTrait
{
    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_ACTIVE => 'Активен'
        ];
    }

    public function getStatus()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }
}