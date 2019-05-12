<?php


namespace app\core\forms\manage\Shop\Good;


use app\core\entities\Shop\Characteristic;
use app\core\entities\Shop\Good\Value;
use yii\base\Model;

class ValueForm extends Model
{
    public $value;

    private $_characteristic;

    public function __construct(Characteristic $characteristic, Value $value = null, $config = [])
    {
        if ($value) {
            $this->value = $value->value;
        }
        $this->_characteristic = $characteristic;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'value' => $this->_characteristic->name,
        ];
    }

    public function getId(): int
    {
        return $this->_characteristic->id;
    }

}