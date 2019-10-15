<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 19.01.2019
 * Time: 13:32
 */

namespace app\core\entities\Shop\queries;


use app\core\entities\Shop\Category;
use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\core\entities\Shop\Category]].
 *
 * @see \app\core\entities\Shop\Category
 */
class CategoryQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;

    public function active()
    {
        return $this->andWhere(['status' => true]);
    }
    /**
     * @inheritdoc
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    /**
     * @inheritdoc
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function isComposition()
    {
        return $this->andWhere(['id' => Category::COMPOSITION_ID]);
    }

    public function isYarn()
    {
        return $this->andWhere(['id' => Category::YARN_ID]);
    }

    public function notComposition()
    {
        $compositionCategory = Category::find()->andWhere(['id' => Category::COMPOSITION_ID])->one();

        return $this->andWhere(['!=', 'id', Category::COMPOSITION_ID])->andWhere([
            'NOT IN',
            'id',
            $compositionCategory->children
        ]);
    }
}