<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 14.01.2019
 * Time: 20:31
 */

namespace app\core\entities\Shop\Good\queries;

use app\core\entities\Shop\Brand;
use app\core\entities\Shop\Good\Good;
use app\core\entities\Shop\queries\BrandQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Good]].
 *
 * @see Good
 */
class GoodQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') .'status' => true]);
    }

    /**
     * @inheritdoc
     * @return Good[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Good|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function activeBrand()
    {
        return $this->joinWith([
            'brand' => function (BrandQuery $query) {
                return $query->andWhere(['brand.status' => Brand::STATUS_ACTIVE]);
            }
        ]);
    }
}