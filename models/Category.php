<?php

namespace app\models;

use app\components\behaviors\UploadImageBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadImageBehavior::className(),
                'fileNameField' => 'image',
                'goodIdField' => 'id',
                'typeSave' => 'single',
                'catalog' => 'category'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['active'], 'integer'],
            [['image'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'active' => 'Активен',
            'imageFile' => 'Изображение',
            'image' => 'Загруженое изображение'
        ];
    }

    public static function getCategoriesArray()
    {
        return self::find()->select(['title','id'])->indexBy('id')->column();
    }

    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['categoryId' => 'id']);
    }
}
