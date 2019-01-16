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
 *
 * @property Good[] $goods
 * @property Category $parent
 */
class Category extends \yii\db\ActiveRecord
{
    public $goods_count;

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
                'class'         => UploadImageBehavior::className(),
                'fileNameField' => 'image',
                'goodIdField'   => 'id',
                'typeSave'      => 'single',
                'catalog'       => 'category',
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
            [['content'], 'string'],
            [['active'], 'integer'],
            [['image'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'parent_id'   => 'Родительская категория',
            'title'       => 'Название',
            'description' => 'Краткое описание',
            'content'     => 'Полное описание',
            'active'      => 'Активен',
            'imageFile'   => 'Изображение',
            'image'       => 'Загруженое изображение',
        ];
    }

    public static function getCategoriesArray()
    {
        return self::find()->select(['title', 'id'])->indexBy('id')->column();
    }

    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['categoryId' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }
}
