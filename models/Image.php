<?php

namespace app\models;

use app\components\behaviors\UploadImageBehavior;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $fileName
 * @property int $goodId
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
                'class' => UploadImageBehavior::className(),
                'fileNameField' => 'fileName',
                'typeSave' => 'multiple',
                'catalog' => 'goods'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goodId'], 'required'],
            [['goodId'], 'filter', 'filter' => function ($value) {
                return (int)$value;
            }],
            [['main'], 'filter', 'filter' => function ($value) {
                return (int)$value;
            }],
            [['goodId', 'main'], 'integer'],
            [['fileName'], 'string', 'max' => 255],
            [['goodId'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['goodId' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'fileName' => 'Имя файла',
            'goodId'   => 'ID товара',
            'main'     => 'Главная картинка товара',
            'imageFile' => 'Загрузка изображения'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'goodId']);
    }
}
