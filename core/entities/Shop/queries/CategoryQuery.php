<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 19.01.2019
 * Time: 13:32
 */

namespace app\core\entities\Shop\queries;


use app\core\entities\Shop\Category;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\core\entities\Shop\Category]].
 *
 * @see \app\core\entities\Shop\Category
 */
class CategoryQuery extends ActiveQuery
{

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
}