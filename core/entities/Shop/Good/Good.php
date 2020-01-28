<?php

namespace app\core\entities\Shop\Good;


use app\core\behaviors\TagDependencyBehavior;
use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Category;
use app\core\entities\Shop\Characteristic;
use app\core\entities\Shop\Composition;
use app\core\entities\Shop\Good\queries\GoodQuery;
use app\core\entities\Shop\Material;
use app\core\entities\Shop\Price;
use app\core\readModels\Shop\RemainingReadRepository;
use app\core\traits\StatusTrait;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "good".
 *
 * @property int $id
 * @property string $article
 * @property string $name
 * @property string $description
 * @property string $characteristic
 * @property string $nameAndColor
 * @property string $color
 * @property int $category_id
 * @property int $brand_id
 * @property int $packaged
 * @property int $status
 * @property int $main_good_id
 * @property integer $main_image_id
 * @property integer $percent
 *
 *
 * @property Brand $brand
 * @property Good $mainGood
 * @property Category $category
 * @property Price $retailPrice
 * @property Price $wholesalePrice
 * @property CategoryAssignment[] $categoryAssignments
 * @property Image[] $images
 * @property Image $mainImage
 * @property Value[] $values
 * @property Composition[] $compositions
 * @property Value $valueColorRelation
 * @property Value[] $valuesYarnRelation
 */
class Good extends ActiveRecord
{
    use StatusTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName()
    {
        return '{{%good}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => ['categoryAssignments', 'images', 'values'],
            ],
            'TagDependencyBehavior' => [
                'class' => TagDependencyBehavior::class,
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
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
            'name' => 'Наименование',
            'description' => 'Описание',
            'characteristic' => 'Дополнительная характеристика',
            'category_id' => 'Категория',
            'composition_id' => 'Состав (категория)',
            'brand_id' => 'Брэнд',
            'packaged' => 'В упаковке',
            'active' => 'Активен',
            'main_good_id' => 'Основной товар',
            'nameAndColor' => 'Товар',
            'mainImage' => 'Фото',
            'percent' => 'Наценка (%)'
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
        return ['images', 'retailPrice', 'wholesalePrice', 'remaining'];
    }

    public static function create(
        $brandId,
        $article,
        $name,
        $description,
        $packaged,
        $mainGoodId = null,
        $status,
        $percent
    ): self
    {
        $good = new static();
        $good->article = $article;
        $good->name = $name;
        $good->description = $description;
        $good->packaged = $packaged;
        $good->brand_id = $brandId;
        $good->main_good_id = $mainGoodId;
        $good->status = $status;
        $good->percent = $percent;

        return $good;
    }

    public function edit($brandId, $article, $name, $description, $packaged, $mainGoodId = null, $status, $percent)
    {
        $this->article = $article;
        $this->name = $name;
        $this->description = $description;
        $this->packaged = $packaged;
        $this->brand_id = $brandId;
        $this->main_good_id = $mainGoodId;
        $this->status = $status;
        $this->percent = $percent;
    }

    // Category

    public function changeMainCategory($categoryId)
    {
        $this->category_id = $categoryId;
    }

    public function assignCategory($id)
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForCategory($id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignments;
    }

    public function revokeCategory($id)
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForCategory($id)) {
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeCategories()
    {
        $this->categoryAssignments = [];
    }

    // Images

    public function addImage(UploadedFile $file)
    {
        $images = $this->images;
        $images[] = Image::create($file);
        $this->updateImages($images);
    }

    public function removeImage($id)
    {
        $images = $this->images;
        foreach ($images as $i => $image) {
            if ($image->isIdEqualTo($id)) {
                unset($images[$i]);
                $this->updateImages($images);
                return;
            }
        }
        throw new \DomainException('Image is not found.');
    }

    public function removeImages()
    {
        $this->updateImages([]);
    }

    public function moveImageUp($id)
    {
        $images = $this->images;
        foreach ($images as $i => $image) {
            if ($image->isIdEqualTo($id)) {
                if ($prev = $images[$i - 1] ?? null) {
                    $images[$i - 1] = $image;
                    $images[$i] = $prev;
                    $this->updateImages($images);
                }
                return;
            }
        }
        throw new \DomainException('Image is not found.');
    }

    public function moveImageDown($id)
    {
        $images = $this->images;
        foreach ($images as $i => $image) {
            if ($image->isIdEqualTo($id)) {
                if ($next = $images[$i + 1] ?? null) {
                    $images[$i] = $next;
                    $images[$i + 1] = $image;
                    $this->updateImages($images);
                }
                return;
            }
        }
        throw new \DomainException('Image is not found.');
    }

    private function updateImages(array $images)
    {
        foreach ($images as $i => $image) {
            $image->setSort($i);
        }
        $this->images = $images;
        $this->populateRelation('mainImage', reset($images));
    }

    public function getMainThumbImageUrl()
    {
        if (isset($this->mainImage)) {
            return $this->mainImage->getThumbFileUrl('file_name', 'main_image');
        }
        return '/img/no-image.svg';
    }

    public function getMainOriginImageUrl()
    {
        if (isset($this->mainImage)) {
            return $this->mainImage->getUploadedFileUrl('file_name');
        }
        return '/img/no-image.svg';
    }

    public function getMainImageImg($sizeTemplate = 'admin')
    {
        return $this->mainImage
            ? Html::img($this->mainImage->getThumbFileUrl('file_name',
                $sizeTemplate)) : Html::img('/img/no-image.svg', ['width' => 100, 'height' => 100]);
    }

    // Value

    public function setValueItem($id, $value)
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                $val->change($value);
                $this->values = $values;
                return;
            }
        }
        $values[] = Value::create($id, $value);
        $this->values = $values;
    }

    public function getValueItem($id): Value
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                return $val;
            }
        }
        return Value::blank($id);
    }

    /** Relation */

    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['good_id' => 'id']);
    }

    public function getImages(): ActiveQuery
    {
        return $this->hasMany(Image::className(), ['good_id' => 'id'])->orderBy('sort');
    }

    public function getMainImage(): ActiveQuery
    {
        return $this->hasOne(Image::class, ['id' => 'main_image_id']);
    }

    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::className(), ['good_id' => 'id']);
    }

    public function getValueColorRelation(): ActiveQuery
    {
        return $this->hasOne(Value::className(), ['good_id' => 'id'])
            ->andWhere(['characteristic_id' => Characteristic::CHARACTERISTIC_COLOR_ID]);
    }

    public function getValuesYarnRelation(): ActiveQuery
    {
        return $this->hasMany(Value::className(), ['good_id' => 'id'])
            ->andWhere([
                'OR',
                ['characteristic_id' => 2],
                ['characteristic_id' => 4],
            ]);
    }

    public function getCharacteristics(): ActiveQuery
    {
        return $this->hasMany(Characteristic::className(), ['id' => 'characteristic_id'])->viaTable('value',
            ['good_id' => 'id']);
    }

    public function getCompositions(): ActiveQuery
    {
        return $this->hasMany(Composition::className(), ['good_id' => 'id']);
    }

    public function getMaterials(): ActiveQuery
    {
        return $this->hasMany(Material::className(), ['id' => 'Material_id'])->viaTable('composition',
            ['good_id' => 'id']);
    }

    public function getMainGood(): ActiveQuery
    {
        return $this->hasOne(Good::className(), ['id' => 'main_good_id']);
    }

    /** Methods */

    public static function getGoodArray()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    public function getFullName()
    {
        return $this->category->name . ' ' . $this->name;
    }

    public function getColor()
    {
        /* @var $color Value */
        $color = $this->valueColorRelation;

        return isset($color->value) ? $color->value : '';
    }

    public function getNameAndColor(): string
    {
        if (!empty($this->color)) {
            return $this->name . ' - ' . $this->color;
        }
        return $this->name;
    }

    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['good_id' => 'id']);
    }

    public function getRetailPrice()
    {
        $key = [
            __CLASS__,
            __FILE__,
            __LINE__,
            $this->id
        ];

        $dependency = new TagDependency([
            'tags' => [
                Price::class,
            ],
        ]);

        $price = Yii::$app->cache->getOrSet($key, function () {
            return $this->getPrices()->lastRetail()->one();
        }, 10 * 24 * 60 * 60, $dependency);

        return $price;
    }

    public function getWholesalePrice()
    {
        return $this->getPrices()->lastWholesale()->one();
    }

    public function getRemaining()
    {
        $remainingReadRepository = new RemainingReadRepository();
        return $remainingReadRepository->getLastRemaining(0, $this->id);
    }

    public function getCategoriesToString()
    {
        $name = '';
        $count = count($this->categoryAssignments);
        foreach ($this->categoryAssignments as $key => $category) {

            $name .= $category->category->name;

            if (($key + 1) < $count) {
                $name .= ', ';
            }
        }
        return $name;
    }

    public static function find()
    {
        return new GoodQuery(get_called_class());
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->images as $image) {
                $image->delete();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $related = $this->getRelatedRecords();

        parent::afterSave($insert, $changedAttributes);

        if (array_key_exists('mainImage', $related)) {
            $this->updateAttributes(['main_image_id' => $related['mainImage'] ? $related['mainImage']->id : null]);
        }

    }
}
