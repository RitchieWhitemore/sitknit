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
        //$goodId=17699;

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
                ->joinWith(['good'])
                ->andFilterWhere(['good_id' => $goodId])
                ->groupBy(['good_id'])
                ->indexBy('good_id');

            $credits = OrderItem::find()
                ->select(['SUM(qty) as totalQty', 'good_id'])
                ->andFilterWhere(['good_id' => $goodId])
                ->joinWith(['good', 'document d'])
                ->andWhere(['OR', ['d.status' => Order::STATUS_SHIPPED], ['d.status' => Order::STATUS_RESERVE]])
                ->groupBy(['good_id'])
                ->indexBy('good_id');

            $reserves = OrderItem::find()
                ->select(['SUM(qty) as totalQty', 'good_id'])
                ->andFilterWhere(['good_id' => $goodId])
                ->joinWith(['good', 'document d'])
                ->andWhere(['d.status' => Order::STATUS_RESERVE])
                ->groupBy(['good_id'])
                ->indexBy('good_id');

            $remaining = [];

            foreach ($debits->each() as $key => $debit) {
                /* @var $debit \app\core\entities\Document\ReceiptItem */

                $itemRemaining = new ItemRemaining($debit->good_id,
                    $debit->good->nameAndColor/*, $this->getReserve($reserves, $key)*/);

                $itemRemaining->setQty($debit->totalQty);
                $remaining[$itemRemaining->id] = $itemRemaining;
            }

            foreach ($credits->each() as $key => $credit) {
                /* @var $credit \app\core\entities\Document\OrderItem */
                if (isset($remaining[$key])) {
                    $itemRemaining = $remaining[$key];
                    $itemRemaining->countDifference($credit->totalQty);
                } else {
                    $itemRemaining = new ItemRemaining($credit->good_id, $credit->good->nameAndColor);
                    $itemRemaining->setQty(-$credit->totalQty);
                    $remaining[$key] = $itemRemaining;
                }
                if ($notNull == 1 && $itemRemaining->isNull()) {
                    unset($remaining[$key]);
                }
            }

            foreach ($reserves->each() as $key => $reserve) {
                /* @var $reserve \app\core\entities\Document\OrderItem */
                if (!isset($remaining[$key])) {
                    $itemRemaining = new ItemRemaining($reserve->good_id, $reserve->good->nameAndColor);
                    $itemRemaining->setQty(0);
                    $itemRemaining->setReserve($reserve->totalQty);
                    $remaining[] = $itemRemaining;
                } else {
                    $itemRemaining = $remaining[$key];
                    $itemRemaining->setReserve($reserve->totalQty);
                }
            }

            uasort($remaining, function ($a, $b) {
                if ($a->good == $b->good) {
                    return 0;
                }
                return ($a->good < $b->good) ? -1 : 1;
            });

            if (count($remaining) == 0) {
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