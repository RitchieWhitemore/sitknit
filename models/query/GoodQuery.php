<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 14.01.2019
 * Time: 20:31
 */

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Good]].
 *
 * @see \app\models\Good
 */
class GoodQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['active' => true]);
    }
    /**
     * @inheritdoc
     * @return \app\models\Good[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    /**
     * @inheritdoc
     * @return \app\models\Good|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}