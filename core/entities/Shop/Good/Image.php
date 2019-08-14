<?php

namespace app\core\entities\Shop\Good;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $file_name
 * @property int $good_id
 * @property integer $sort
 *
 * @property Good $good
 */
class Image extends ActiveRecord
{
    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file_name = $file;
        return $photo;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%image}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'                 => ImageUploadBehavior::className(),
                'attribute'             => 'file_name',
                'createThumbsOnRequest' => true,
                'filePath'              => '@webroot/img/goods/[[attribute_good_id]]/[[id]].[[extension]]',
                'fileUrl'               => '@web/img/goods/[[attribute_good_id]]/[[id]].[[extension]]',
                'thumbPath'             => '@webroot/cache/goods/[[attribute_good_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl'              => '@web/cache/goods/[[attribute_good_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs'                => [
                    'admin'        => ['width' => 100, 'height' => 70],
                    'thumb'        => ['width' => 640, 'height' => 480],
                    'catalog_list' => ['width' => 220, 'height' => 150],
                    'main_image'   => ['width' => 300, 'height' => 300],
                    'set_prices' => ['width' => 50, 'height' => 50],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'file_name' => 'Имя файла',
            'good_id'   => 'ID товара',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
