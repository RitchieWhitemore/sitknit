<?php


namespace app\core\forms\manage\Shop;

use app\core\entities\Shop\Country;
use yii\base\Model;

class CountryForm extends Model
{
    public $name;
    public $description;

    private $_country;

    public function __construct(Country $country = null, $config = [])
    {
        if ($country) {
            $this->name = $country->name;
            $this->description = $country->description;
            $this->_country = $country;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [
                ['name'],
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
            'description' => 'Описание',
        ];
    }

}