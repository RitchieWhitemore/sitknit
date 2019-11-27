<?php


namespace app\core\entities\Document\queries;


use app\core\entities\Document\Order;
use app\modules\user\models\User;
use yii\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|Order
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byClient(): OrderQuery
    {
        /* @var $user User */
        $user = \Yii::$app->user->identity;
        return $this->andWhere(['partner_id' => $user->partner_id]);
    }
}