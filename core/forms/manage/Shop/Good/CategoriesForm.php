<?php


namespace app\core\forms\manage\Shop\Good;


use app\core\entities\Shop\Category;
use app\core\entities\Shop\Good\Good;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(Good $good = null, $config = [])
    {
        if ($good) {
            $this->others = ArrayHelper::getColumn($good->categoryAssignments, 'category_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['others'], 'required'],
            ['others', 'each', 'rule' => ['integer']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'others' => 'Категории',
        ];
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->andWhere([
            '>',
            'depth',
            0
        ])->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });
    }
}