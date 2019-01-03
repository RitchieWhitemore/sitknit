<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "good".
 *
 * @property int $id
 * @property string $article
 * @property string $title
 * @property string $description
 * @property string $characteristic
 * @property int $categoryId
 * @property int $brandId
 * @property int $countryId
 * @property int $packaged
 *
 * @property Brand $brand
 * @property Category $category
 * @property Country $country
 */
class Good extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'good';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['categoryId', 'brandId', 'countryId', 'packaged', 'active'], 'integer'],
            [['article'], 'string', 'max' => 50],
            [['title', 'description', 'characteristic'], 'string', 'max' => 255],
            [['brandId'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brandId' => 'id']],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['categoryId' => 'id']],
            [['countryId'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['countryId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article' => 'Артикул',
            'title' => 'Наименование',
            'description' => 'Описание',
            'characteristic' => 'Дополнительная характеристика',
            'categoryId' => 'Категория',
            'brandId' => 'Брэнд',
            'countryId' => 'Страна',
            'packaged' => 'В упаковке',
            'active' => 'Активен'
        ];
    }

    public function fields()
    {
        return [
            'images' => 'images',
        ];

    }

    public function extraFields()
    {
        return ['images'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brandId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'categoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'countryId']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['goodId' => 'id']);
    }

    public static function getGoodArray()
    {
        return self::find()->select(['title','id'])->indexBy('id')->column();
    }
}
