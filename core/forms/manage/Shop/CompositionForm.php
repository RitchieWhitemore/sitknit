<?php


namespace app\core\forms\manage\Shop;


use app\core\entities\Shop\Composition;
use app\core\entities\Shop\Material;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class CompositionForm extends Model
{
    public $value;

    public $good_id;
    public $material_id;

    private $_composition;

    public function __construct(Composition $composition = null, $config = [])
    {
        if ($composition) {
            $this->good_id = $composition->good_id;
            $this->material_id = $composition->material_id;
            $this->value = $composition->value;

            $this->_composition = $composition;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['good_id', 'material_id', 'value'], 'required'],
            [['good_id', 'material_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [
                ['good_id', 'material_id'],
                'unique',
                'targetAttribute' => ['good_id', 'material_id'],
                'targetClass'     => Composition::class,
                'filter'          => $this->_composition ? function ($query) {
                    /* @var $query ActiveQuery */
                    if ($this->_composition->material_id != $this->material_id) return false;

                    return $query->andWhere(['<>', 'good_id', $this->good_id])
                        ->andWhere(['<>', 'material_id', $this->material_id]);
                } : null,
                'message'         => 'Такой материал уже есть в составе'
            ]

        ];
    }

    public function attributeLabels()
    {
        return [
            'material_id' => 'Метериал',
            'value'       => 'Количество',
        ];
    }

    public function materialList(): array
    {
        return ArrayHelper::map(Material::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

}

