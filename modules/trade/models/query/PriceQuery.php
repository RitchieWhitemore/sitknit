<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 20.02.2019
 * Time: 13:30
 */

namespace app\modules\trade\models\query;


use app\modules\trade\models\Price;
use yii\db\ActiveQuery;
use yii\db\Query;

class PriceQuery extends ActiveQuery
{
    public function lastRetail()
    {
        $subQuery = (new Query())->select('MAX(date)')->from('price')->where(['good_id' => $this->primaryModel->id, 'type_price' => Price::TYPE_PRICE_RETAIL]);
        return $this->andWhere(['type_price' => Price::TYPE_PRICE_RETAIL, 'date' => $subQuery]);
    }

    public function lastWholesale()
    {
        $subQuery = (new Query())->select('MAX(date)')->from('price')->where(['good_id' => $this->primaryModel->id, 'type_price' => Price::TYPE_PRICE_WHOLESALE]);
        return $this->andWhere(['type_price' => Price::TYPE_PRICE_WHOLESALE, 'date' => $subQuery]);
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