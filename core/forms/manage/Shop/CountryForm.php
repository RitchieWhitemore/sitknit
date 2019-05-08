<?php


namespace app\core\forms\manage\Shop;

use app\core\entities\Shop\Country;
use app\core\validators\SlugValidator;
use yii\base\Model;

class CountryForm extends Model
{
    public $name;
    public $slug;
    public $description;

    private $_country;

    public function __construct(Country $country = null, $config = [])
    {
        if ($country) {
            $this->name = $country->name;
            $this->slug = $country->slug;
            $this->description = $country->description;
            $this->_country = $country;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [
                ['name', 'slug'],
                'unique',
                'targetClass' => Country::class,
                'filter'      => $this->_country ? ['<>', 'id', $this->_country->id] : null
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Название',
            'slug'        => 'Транслит',
            'description' => 'Описание',
        ];
    }

}