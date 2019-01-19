<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 19.01.2019
 * Time: 13:32
 */

namespace app\models\query;


use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Category]].
 *
 * @see \app\models\Category
 */
class CategoryQuery extends ActiveQuery
{

    public function active()
    {
        return $this->andWhere(['active' => true]);
    }
    /**
     * @inheritdoc
     * @return \app\models\Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    /**
     * @inheritdoc
     * @return \app\models\Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}