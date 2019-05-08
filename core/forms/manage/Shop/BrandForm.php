<?php


namespace app\core\forms\manage\Shop;

use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Country;
use app\core\validators\SlugValidator;
use yii\base\Model;
use yii\web\UploadedFile;

class BrandForm extends Model
{
    public $name;
    public $slug;
    public $description;
    public $image;
    public $country_id;
    public $status;

    /**
     * @var UploadedFile
     */
    public $imageFile;

    private $_brand;

    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->description = $brand->description;
            $this->image = $brand->image;
            $this->country_id = $brand->country_id;
            $this->status = $brand->status;

            $this->_brand = $brand;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'country_id', 'status'], 'required'],
            [['name', 'slug'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['status', 'country_id'], 'integer'],
            [['image'], 'string'],
            [
                ['country_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Country::className(),
                'targetAttribute' => ['country_id' => 'id']
            ],
            ['slug', SlugValidator::class],
            [
                ['name', 'slug'],
                'unique',
                'targetClass' => Brand::class,
                'filter'      => $this->_brand ? ['<>', 'id', $this->_brand->id] : null
            ],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Название',
            'slug'        => 'Траслит',
            'description' => 'Описание',
            'status'      => 'Активен',
            'imageFile'   => 'Изображение',
            'image'       => 'Загруженое изображение',
            'country_id'  => 'Страна',
        ];
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