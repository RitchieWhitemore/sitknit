<?php

namespace app\core\entities\Shop;

use app\core\behaviors\UploadImageBehavior;
use app\models\query\BrandQuery;
use core\entities\Shop\Good\Good;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $image
 * @property int $country_id
 * @property int $status
 *
 * @property Country $country
 */
class Brand extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function create($name, $slug, $description, $countryId, $status): self
    {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->description = $description;
        $brand->country_id = $countryId;
        $brand->status = $status;

        return $brand;
    }

    public function edit($name, $slug, $description, $countryId, $status)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->country_id = $countryId;
        $this->status = $status;
    }

    public static function tableName()
    {
        return '{{%brand}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'createThumbsOnRequest' => true,
                'filePath' => '@webroot/img/brand/[[attribute_name]].[[extension]]',
                'fileUrl' => '@web/img/brand/[[attribute_name]].[[extension]]',
                'thumbPath' => '@webroot/img/cache/brand/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@web/img/cache/brand/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
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
            'id'          => 'ID',
            'name'        => 'Название',
            'slug'        => 'Транслит',
            'description' => 'Описание',
            'active'      => 'Активен',
            'imageFile'   => 'Изображение',
            'image'       => 'Загруженое изображение',
            'country_id'  => 'Страна',
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
        $brands = (new Query())->select('brand_id')->from('good')->where([
            'in',
            'category_id',
            $childrenCategory
        ])->groupBy('brand_id');

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

    public static function statusList(): array
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_ACTIVE   => 'Активен',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }
}
