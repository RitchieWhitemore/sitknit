<?php


namespace app\core\forms\manage\Shop;


use app\core\entities\Shop\Category;
use app\core\validators\SlugValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class CategoryForm extends Model
{
    public $id;
    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentId;
    public $content;
    public $status;
    public $image;

    /**
     * @var UploadedFile
     */
    public $imageFile;

    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->image = $category->image;


            $this->_category = $category;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['parentId'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function parentCategoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
            return true;
        }
        return false;
    }
}