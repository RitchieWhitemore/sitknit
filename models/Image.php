<?php

namespace app\models;

use app\components\behaviors\UploadImageMultipleBehavior;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $file_name
 * @property int $good_id
 * @property int $main
 *
 * @property Good $good
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    public function behaviors()
    {
        return [
            [
                'class'         => UploadImageMultipleBehavior::className(),
                'fileNameField' => 'file_name',
                'catalog'       => 'goods',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['good_id'], 'required'],
            [['good_id'], 'filter', 'filter' => function ($value) {
                return (int)$value;
            }],
            [['main'], 'filter', 'filter' => function ($value) {
                return (int)$value;
            }],
            [['good_id', 'main'], 'integer'],
            [['file_name'], 'string', 'max' => 255],
            [['good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['good_id' => 'id']],
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
            'main'      => 'Главная картинка товара',
            'imageFile' => 'Загрузка изображения',
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
