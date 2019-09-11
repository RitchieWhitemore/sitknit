<?php


namespace app\core\readModels\Shop;


use app\core\entities\Document\Order;
use app\core\entities\Document\OrderItem;
use app\core\entities\Document\Receipt;
use app\core\entities\Document\ReceiptItem;
use app\core\entities\ItemRemaining;
use app\core\entities\Shop\Good\Good;
use app\core\entities\Shop\Price;
use Yii;
use yii\caching\TagDependency;

class RemainingReadRepository
{
    public function getLastRemaining($notNull = null): array
    {
        $key = [
            __CLASS__,
            __FILE__,
            __LINE__
        ];

        if ($notNull == true) {
            $key[] = $notNull;
        }

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

        $remaining = Yii::$app->cache->getOrSet($key, function () use ($notNull) {
            /* @var $credits [] OrderItem */

            $debits = ReceiptItem::find()->with(['good'])->indexBy('good_id')
                ->all();
            $credits = OrderItem::find()->joinWith([
                'good',
                'document d'
            ])->where(['d.status' => Order::STATUS_SHIPPED])->indexBy('good_id')
                ->all();

            $remaining = [];

            foreach ($debits as $key => $debit) {
                /* @var $debit \app\core\entities\Document\ReceiptItem */

                $itemRemaining = new ItemRemaining($debit);
                $itemRemaining->setQty($debit->qty);
                if (array_key_exists($key, $credits)) {

                    $itemRemaining->qty = $debit->qty - $credits[$key]->qty;

                    if ($notNull == null && $itemRemaining->qty == 0) {
                        $remaining[] = $itemRemaining;
                    }

                    unset($credits[$key]);
                } else {
                    $remaining[] = $itemRemaining;
                }
            }

            foreach ($credits as $credit) {
                /* @var $credit \app\core\entities\Document\OrderItem */
                $itemRemaining = new ItemRemaining($credit);
                $itemRemaining->setQty(-$credit->qty);
                $remaining[] = $itemRemaining;
            }

            uasort($remaining, function ($a, $b) {
                if ($a->good == $b->good) {
                    return 0;
                }
                return ($a->good < $b->good) ? -1 : 1;
            });

            return $remaining;
        }, 10 * 24 * 60 * 60, $dependency);

        return $remaining;
    }
}