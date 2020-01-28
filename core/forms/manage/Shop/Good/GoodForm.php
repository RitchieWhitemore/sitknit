<?php


namespace app\core\forms\manage\Shop\Good;

use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Characteristic;
use app\core\entities\Shop\Good\Good;
use app\core\forms\CompositeForm;
use app\core\forms\manage\Shop\CompositionForm;

/**
 * Class GoodForm
 * @package app\core\forms\manage\Shop\Good
 *
 * @property CategoriesForm $categories
 * @property ImagesForm $images
 * @property ValueForm[] $values
 * @property CompositionForm[] $compositions
 */
class GoodForm extends CompositeForm
{
    public $id;
    public $article;
    public $name;
    public $description;
    public $packaged;
    public $status;
    public $brand_id;
    public $category_id;
    public $main_good_id;
    public $characteristic;
    public $mainGood;
    public $percent;

    private $_good;

    public function __construct(Good $good = null, $config = [])
    {
        if ($good) {
            $this->name = $good->name;
            $this->article = $good->article;
            $this->description = $good->description;
            $this->packaged = $good->packaged;
            $this->brand_id = $good->brand_id;
            $this->category_id = $good->category_id;
            $this->characteristic = $good->characteristic;
            $this->status = $good->status;
            $this->main_good_id = $good->main_good_id;
            $this->percent = $good->percent;

            $this->categories = new CategoriesForm($good);
            $this->mainGood = $good->mainGood;

            $this->values = array_map(function (Characteristic $characteristic) use ($good) {
                return new ValueForm($characteristic, $good->getValueItem($characteristic->id));
            }, Characteristic::find()->orderBy('sort')->all());

            $this->_good = $good;
        } else {
            $this->categories = new CategoriesForm();
            $this->images = new ImagesForm();
            $this->values = array_map(function (Characteristic $characteristic) {
                return new ValueForm($characteristic);
            }, Characteristic::find()->orderBy('sort')->all());
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'article', 'brand_id'], 'required'],
            [['brand_id', 'packaged', 'status', 'percent'], 'integer'],
            [['article'], 'string', 'max' => 50],
            [
                ['article'],
                'unique',
                'targetClass' => Good::class,
                'filter' => $this->_good ? ['<>', 'id', $this->_good->id] : null
            ],
            [['name', 'description'], 'string', 'max' => 255],
            [
                ['brand_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Brand::className(),
                'targetAttribute' => ['brand_id' => 'id']
            ],
            [
                ['main_good_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Good::className(),
                'targetAttribute' => ['main_good_id' => 'id']
            ],
            ['percent', 'default', 'value' => 0]
        ];
    }

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
            'main' => 'Основная',
            'others' => 'Другие',
            'percent' => 'Наценка (%)',
            'status' => 'Статус'
        ];
    }

    protected function internalForms(): array
    {
        return ['categories', 'images', 'values'];
    }
}