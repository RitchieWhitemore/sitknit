<?php


namespace app\core\entities\Shop\queries;


use app\core\entities\Shop\Brand;
use yii\db\ActiveQuery;

class BrandQuery extends ActiveQuery
{
    public function inCategory($id)
    {
        return $this->addSelect(['g.category_id'])->joinWith(['goods g'])->where(['g.category_id' => $id])->groupBy('brand.name');
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

    public function active(): ActiveQuery
    {
        return $this->andWhere(['status' => Brand::STATUS_ACTIVE]);
    }
}