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

            $reserves = OrderItem::find()
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

                $itemRemaining = new ItemRemaining($debit, $this->getReserve($reserves, $key));

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
                $itemRemaining = new ItemRemaining($credit, $this->getReserve($reserves, $key));
                $itemRemaining->setQty(-$credit->totalQty);
                $remaining[] = $itemRemaining;
            }

            foreach ($reserves as $key => $reserve) {
                if (!isset($remaining[$key])) {
                    $itemRemaining = new ItemRemaining($reserve, $reserve);
                    $itemRemaining->setQty(0);
                    $remaining[] = $itemRemaining;
                }
            }

            uasort($remaining, function ($a, $b) {
                if ($a->good == $b->good) {
                    return 0;
                }
                return ($a->good < $b->good) ? -1 : 1;
            });

            if (count($remaining) == 0 && count($reserves) == 0) {
                $remaining[] = new ItemRemainingDummy();
            }
            return $remaining;
        }, 10 * 24 * 60 * 60, $dependency);

        return $remaining;
    }

    private function deleteItemArray(array $array, $key)
    {
        if (isset($array[$key])) {
            unset($array[$key]);
        }
    }

    private function getReserve(array $array, $key)
    {
        $returnItem = isset($array[$key]) ? $array[$key] : null;
        $this->deleteItemArray($array, $key);
        return $returnItem;
    }
}