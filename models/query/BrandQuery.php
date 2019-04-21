<?php


namespace app\models\query;


use yii\db\ActiveQuery;
use yii\db\Query;

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
}