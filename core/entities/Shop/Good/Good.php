<?php

namespace app\core\entities\Shop\Good;


use app\models\Attribute;
use app\models\AttributeValue;
use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use app\models\Composition;
use app\models\Image;
use app\core\entities\Shop\Good\queries\GoodQuery;
use app\modules\trade\models\Price;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "good".
 *
 * @property int $id
 * @property string $article
 * @property string $name
 * @property string $description
 * @property string $characteristic
 * @property int $category_id
 * @property int $brand_id
 * @property int $packaged
 * @property int $status
 * @property int $main_good_id
 * @property string $mainImageUrl
 *
 *
 * @property Brand $brand
 * @property Category $category
 * @property Price $priceRetail
 */
class Good extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function create($brandId, $categoryId, $article, $name, $description, $packaged, $mainGoodId = null, $status): self
    {
        $good = new static();
        $good->article = $article;
        $good->name = $name;
        $good->description = $description;
        $good->packaged = $packaged;
        $good->brand_id = $brandId;
        $good->category_id = $categoryId;
        $good->main_good_id = $mainGoodId;
        $good->status = $status;

        return $good;
    }

    public function edit($brandId, $categoryId, $article, $name, $description, $packaged, $mainGoodId = null, $status)
    {
        $this->article = $article;
        $this->name = $name;
        $this->description = $description;
        $this->packaged = $packaged;
        $this->brand_id = $brandId;
        $this->category_id = $categoryId;
        $this->main_good_id = $mainGoodId;
        $this->status = $status;
    }

    public static function tableName()
    {
        return '{{%good}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'article'        => 'Артикул',
            'name'           => 'Наименование',
            'description'    => 'Описание',
            'characteristic' => 'Дополнительная характеристика',
            'category_id'    => 'Категория',
            'composition_id' => 'Состав (категория)',
            'brand_id'       => 'Брэнд',
            'packaged'       => 'В упаковке',
            'active'         => 'Активен',
            'main_good_id'   => 'Основной товар',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'article',
            'brand',
            'name',
            'category',
            'nameAndColor',
        ];

    }

    public function extraFields()
    {
        return ['images', 'priceRetail', 'priceWholesale'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComposition()
    {
        return $this->hasOne(Composition::className(), ['id' => 'composition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['good_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['good_id' => 'id']);
    }

    public function getGoodAttributes()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])->viaTable('attribute_value', ['good_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'main_good_id']);
    }

    public static function getGoodArray()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    /**
     * @return string
     */
    public function getMainImageUrl()
    {
        $Image = Image::find()->where(['good_id' => $this->id])->andWhere(['main' => 1])->one();

        if (!isset($Image)) {
            $Image = Image::find()->where(['good_id' => $this->id])->one();
        }

        if (isset($Image)) {
            return '/img/goods/' . $this->id . '/' . $Image->file_name;
        }
    }

    public function getFullName()
    {
        return $this->category->name . ' ' . $this->name;
    }

    public function getNameAndColor()
    {
        $color = $this->getAttributeValues()->where(['attribute_id' => 1])->one();

        if (isset($color)) {
            return $this->name . ' - ' . $color->value;
        }

        return $this->name;
    }

    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['good_id' => 'id']);
    }

    public function getPriceRetail()
    {
        return $this->getPrices()->lastRetail()->one();
    }

    public function getPriceWholesale()
    {
        return $this->getPrices()->lastWholesale()->one();
    }

    public static function NextOrPrev($currentId, $categoryId)
    {
        $records = self::find()->where(['category_id' => $categoryId])->orderBy('id DESC')->all();

        foreach ($records as $i => $record) {
            if ($record->id == $currentId) {
                $next = isset($records[$i - 1]->id) ? $records[$i - 1]->id : null;
                $prev = isset($records[$i + 1]->id) ? $records[$i + 1]->id : null;
                break;
            }
        }
        return ['next' => $next, 'prev' => $prev];
    }

    public static function find()
    {
        return new GoodQuery(get_called_class());
    }
}
