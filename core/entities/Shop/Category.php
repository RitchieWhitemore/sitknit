<?php

namespace app\core\entities\Shop;

use app\core\entities\Shop\queries\CategoryQuery;
use app\core\entities\Shop\Good\Good;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $title
 * @property string $image
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 *
 * @property Good[] $goods
 * @property Category $parent
 * @property Category[] $parents
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $goods_count;

    public static function create($name, $slug, $title, $description): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;

        return $category;
    }

    public function edit($name, $slug, $title, $description)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors(): array
    {
        return [
            NestedSetsBehavior::className(),
            [
                'class'                 => ImageUploadBehavior::className(),
                'attribute'             => 'image',
                'createThumbsOnRequest' => true,
                'filePath'              => '@webroot/img/category/[[attribute_name]].[[extension]]',
                'fileUrl'               => '@web/img/category/[[attribute_name]].[[extension]]',
                'thumbPath'             => '@webroot/img/cache/category/[[profile]]_[[id]].[[extension]]',
                'thumbUrl'              => '@web/img/cache/category/[[profile]]_[[id]].[[extension]]',
                'thumbs'                => [
                    'admin'        => ['width' => 100, 'height' => 70],
                    'thumb'        => ['width' => 640, 'height' => 480],
                    'catalog_list' => ['width' => 220, 'height' => 150],
                ],
            ],
            'slug' => [
                'class'                => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute'        => 'slug',
                'attribute'            => 'name',
                // optional params
                'ensureUnique'         => true,
                'replacement'          => '-',
                'lowercase'            => true,
                'immutable'            => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Название',
            'slug'        => 'Транслит',
            'title'       => 'Заголовок',
            'description' => 'Краткое описание',
            'content'     => 'Полное описание',
            'Status'      => 'Статус',
            'imageFile'   => 'Изображение',
            'image'       => 'Загруженое изображение',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'parent',
        ];
    }

    public static function getCategoriesArray()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['category_id' => 'id']);
    }

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }

    public function getCountGoods()
    {
        $categories = self::find()->where(['parent_id' => $this->id])->active()->indexBy('id')->column();

        return Good::find()->where(['IN', 'category_id', $categories])->active()->count();
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}
