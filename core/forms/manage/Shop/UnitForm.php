<?php


namespace app\core\forms\manage\Shop;


use app\core\entities\Shop\Unit;
use yii\base\Model;

class UnitForm extends Model
{
    public $name;
    public $fullName;

    private $_unit;

    public function __construct(Unit $unit = null, $config = [])
    {
        if ($unit) {
            $this->name = $unit->name;
            $this->fullName = $unit->full_name;

            $this->_unit = $unit;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 10],
            [['fullName'], 'string', 'max' => 25],
            [['name'], 'unique', 'targetClass' => Unit::class, 'filter' => $this->_unit ? ['<>', 'id', $this->_unit->id] : null]
        ];
    }
}