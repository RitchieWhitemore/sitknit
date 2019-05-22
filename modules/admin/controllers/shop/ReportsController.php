<?php


namespace app\modules\admin\controllers\shop;


use app\core\entities\ItemRemaining;
use app\modules\trade\models\OrderItem;
use app\core\entities\Document\ReceiptItem;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportsController extends Controller
{
    public function actionRemaining()
    {
        /* @var $credits [] OrderItem */

        $debits = ReceiptItem::find()->with(['good'])->groupBy(['good_id'])->indexBy('good_id')->all();
        $credits = OrderItem::find()->with(['good'])->groupBy(['good_id'])->indexBy('good_id')->all();

        $remaining = [];

        foreach ($debits as $key => $debit) {
            /* @var $debit \app\core\entities\Document\ReceiptItem */

            if (array_key_exists($key, $credits)) {

                $itemRemaining = new ItemRemaining();
                $itemRemaining->good = $debit->good->nameAndColor;
                $itemRemaining->qty = $debit->qty - $credits[$key]->qty;

                if ($itemRemaining->qty > 0) {
                    $remaining[] = $itemRemaining;
                }
                unset($credits[$key]);
            } else {
                $itemRemaining = new ItemRemaining();
                $itemRemaining->good = $debit->good->nameAndColor;
                $itemRemaining->qty = $debit->qty;

                $remaining[] = $itemRemaining;
            }
        }

        foreach ($credits as $credit) {
            $itemRemaining = new ItemRemaining();
            $itemRemaining->good = $credit->good->nameAndColor;
            $itemRemaining->qty = -$credit->qty;

            $remaining[] = $itemRemaining;
        }

        uasort($remaining, function ($a, $b) {
            if ($a->good == $b->good) {
                return 0;
            }
            return ($a->good < $b->good) ? -1 : 1;
        });

        $totalDebitActiveProvider = new ArrayDataProvider([
            'allModels'  => $remaining,
            'pagination' => false,
        ]);

        return $this->render('remaining', ['totalDebitActiveProvider' => $totalDebitActiveProvider]);
    }

    public function actionDebit()
    {
        $deditQuery = ReceiptItem::find()->groupBy(['good_id']);

        $totalDebitActiveProvider = new ActiveDataProvider([
            'query'      => $deditQuery,
            'pagination' => false
        ]);

        return $this->render('debit', ['totalDebitActiveProvider' => $totalDebitActiveProvider]);
    }

    public function actionCredit()
    {
        $creditQuery = OrderItem::find()->with('order');

        $totalDebitActiveProvider = new ArrayDataProvider([
            'allModels'  => $creditQuery->all(),
            'pagination' => false,
            'sort'       => [
                'defaultOrder' => [
                    'good.nameAndColor' => SORT_ASC
                ]
            ]
        ]);

        $totalDebitActiveProvider->setSort([
            'attributes' => [
                'good.nameAndColor'
            ]
        ]);

        return $this->render('credit', ['totalDebitActiveProvider' => $totalDebitActiveProvider]);
    }
}