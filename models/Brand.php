<?php

namespace app\models;

use app\components\behaviors\UploadImageBehavior;
use app\models\query\BrandQuery;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property Country $country
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadImageBehavior::className(),
                'fileNameField' => 'image',
                'goodIdField' => 'id',
                'catalog' => 'brand',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['active', 'country_id'], 'integer'],
            [['image'], 'string'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'active' => 'Активен',
            'imageFile' => 'Изображение',
            'image' => 'Загруженое изображение',
            'country_id' => 'Страна',
        ];
    }

    public static function getBrandsArray()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    public static function getBrandsInCategory()
    {
        $childrenCategory = (new Query())->from('category')->where(['parent_id' => 1])->column();
        $childrenCategory[] = 1;
        $brands = (new Query())->select('brand_id')->from('good')->where(['in', 'category_id', $childrenCategory])->groupBy('brand_id');

        return $brands;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['brand_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public static function find()
    {
        return new BrandQuery(get_called_class());
    }
}
