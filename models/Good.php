<?php

namespace app\models;


use app\models\query\GoodQuery;
use app\modules\trade\models\Price;

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
 * @property int $country_id
 * @property int $packaged
 * @property string $mainImageUrl
 *
 *
 * @property Brand $brand
 * @property Category $category
 * @property Price $priceRetail
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
            [['name'], 'required'],
            [['category_id', 'composition_id', 'brand_id', 'packaged', 'active'], 'integer'],
            [['article'], 'string', 'max' => 50],
            [['name', 'description', 'characteristic'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['main_good_id'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['main_good_id' => 'id']],
        ];
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
            'name',
            'category',
            'images',
            'nameAndColor',
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
