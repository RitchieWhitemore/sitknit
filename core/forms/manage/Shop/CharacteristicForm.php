<?php


namespace app\core\forms\manage\Shop;


use app\core\entities\Shop\Characteristic;
use yii\base\Model;

class CharacteristicForm extends Model
{
    public $name;
    public $sort;
    public $unit_id;

    private $_characteristic;

    public function __construct(Characteristic $characteristic = null, $config = [])
    {
        if ($characteristic) {
            $this->name = $characteristic->name;
            $this->unit_id = $characteristic->unit_id;
            $this->sort = $characteristic->sort;

            $this->_characteristic = $characteristic;
        } else {
            $this->sort = Characteristic::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['name', 'sort'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['unit_id'], 'integer'],
            [['sort'], 'integer'],
            [['name'], 'unique', 'targetClass' => Characteristic::class, 'filter' => $this->_characteristic ? ['<>', 'id', $this->_characteristic->id] : null]
        ];
    }
}