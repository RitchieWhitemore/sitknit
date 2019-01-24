<?php

namespace app\models;


use app\models\query\GoodQuery;

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
            'title'          => 'Наименование',
            'description'    => 'Описание',
            'characteristic' => 'Дополнительная характеристика',
            'categoryId'     => 'Категория',
            'brandId'        => 'Брэнд',
            'countryId'      => 'Страна',
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
            'title',
            'category',
            'images',
            'titleAndColor'
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

    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['good_id' => 'id']);
    }

    public function getGoodAttributes()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])->viaTable('attribute_value', ['good_id' => 'id']);
    }

    public function getMainGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'main_good_id']);
    }

    public static function getGoodArray()
    {
        return self::find()->select(['title', 'id'])->indexBy('id')->column();
    }

    public function getMainImageUrl()
    {
        $Image = Image::find()->where(['goodId' => $this->id])->andWhere(['main' => 1])->one();

        if (!isset($Image)) {
            $Image = Image::find()->where(['goodId' => $this->id])->one();
        }

        if (isset($Image)) {
            return '/img/goods/' . $this->id . '/' . $Image->fileName;
        }
    }

    public function getFullTitle()
    {
        return $this->category->title . ' ' . $this->title;
    }

    public function getTitleAndColor() {
        $color = '';
        return $this->title . ' ' . $color;
    }

    public static function NextOrPrev($currentId, $categoryId)
    {
        $records = self::find()->where(['categoryId' => $categoryId])->orderBy('id DESC')->all();

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
