<?php


namespace app\core\readModels\Shop;


use app\core\entities\Document\Order;
use app\core\entities\Document\OrderItem;
use app\core\entities\Document\Receipt;
use app\core\entities\Document\ReceiptItem;
use app\core\entities\ItemRemaining;
use app\core\entities\ItemRemainingDummy;
use app\core\entities\Shop\Good\Good;
use app\core\entities\Shop\Price;
use Yii;
use yii\caching\TagDependency;

class RemainingReadRepository
{
    public function getLastRemaining($notNull = 0, $goodId = null)
    {
        $key = [
            __CLASS__,
            __FILE__,
            __LINE__,
            $notNull,
            $goodId
        ];

        $dependency = new TagDependency([
            'tags' => [
                Receipt::class,
                ReceiptItem::class,
                Order::class,
                OrderItem::class,
                Price::class,
                Good::class,
            ],
        ]);

        $remaining = Yii::$app->cache->getOrSet($key, function () use ($notNull, $goodId) {
            /* @var $credits [] OrderItem */

            $debits = ReceiptItem::find()
                ->select(['SUM(qty) as totalQty', 'good_id'])
                ->andFilterWhere(['good_id' => $goodId])
                ->groupBy(['good_id'])
                ->indexBy('good_id')
                ->all();

            $credits = OrderItem::find()
                ->select(['SUM(qty) as totalQty', 'good_id'])
                ->andFilterWhere(['good_id' => $goodId])
                ->joinWith(['good', 'document d'])
                ->andWhere(['OR', ['d.status' => Order::STATUS_SHIPPED], ['d.status' => Order::STATUS_RESERVE]])
                ->groupBy(['good_id'])
                ->indexBy('good_id')
                ->all();

            $reserve = OrderItem::find()
                ->select(['SUM(qty) as totalQty', 'good_id'])
                ->andFilterWhere(['good_id' => $goodId])
                ->joinWith(['good', 'document d'])
                ->andWhere(['d.status' => Order::STATUS_RESERVE])
                ->groupBy(['good_id'])
                ->indexBy('good_id')
                ->all();

            $remaining = [];

            foreach ($debits as $key => $debit) {
                /* @var $debit \app\core\entities\Document\ReceiptItem */

                $itemRemaining = new ItemRemaining($debit, isset($reserve[$key]) ? $reserve[$key] : null);
                $itemRemaining->setQty($debit->totalQty);
                if (array_key_exists($key, $credits)) {

                    $itemRemaining->qty = $debit->totalQty - $credits[$key]->totalQty;

                    if ($notNull == 0) {
                        $remaining[] = $itemRemaining;
                    } elseif ($notNull == 1 && $itemRemaining->isNotNull()) {
                        $remaining[] = $itemRemaining;
                    }

                    unset($credits[$key]);
                } else {
                    $remaining[] = $itemRemaining;
                }
            }

            foreach ($credits as $key => $credit) {
                /* @var $credit \app\core\entities\Document\OrderItem */
                $itemRemaining = new ItemRemaining($credit, isset($reserve[$key]) ? $reserve[$key] : null);
                $itemRemaining->setQty(-$credit->qty);
                $remaining[] = $itemRemaining;
            }

            uasort($remaining, function ($a, $b) {
                if ($a->good == $b->good) {
                    return 0;
                }
                return ($a->good < $b->good) ? -1 : 1;
            });

            /*if (is_null($goodId)) {
                return $remaining;
            }
            return isset($remaining[0]) ? $remaining[0]->qty : 0;*/
            if (count($remaining) == 0) {
                $remaining[] = new ItemRemainingDummy();
            }
            return $remaining;
        }, 10 * 24 * 60 * 60, $dependency);

        return $remaining;
    }
}