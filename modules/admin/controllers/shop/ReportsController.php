<?php


namespace app\modules\admin\controllers\shop;


use app\core\entities\Document\Order;
use app\core\entities\Document\OrderItem;
use app\core\entities\Document\Purchase;
use app\core\entities\Document\ReceiptItem;
use app\core\helpers\ColorHelper;
use app\core\readModels\Shop\RemainingReadRepository;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\Controller;

class ReportsController extends Controller
{
    private $remaining;

    public function __construct(
        $id,
        $module,
        RemainingReadRepository $remaining,
        $config = []
    ) {
        $this->remaining = $remaining;
        parent::__construct($id, $module, $config);
    }

    public function actionRemaining($notNull = 0)
    {
        $remaining = $this->remaining->getLastRemaining($notNull);

        $remainingActiveProvider = new ArrayDataProvider([
            'allModels'  => $remaining,
            'pagination' => false,
        ]);

        return $this->render('remaining', ['remainingActiveProvider' => $remainingActiveProvider]);
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
        $creditQuery = OrderItem::find()->with('document');

        $totalDebitActiveProvider = new ArrayDataProvider([
            'allModels'  => $creditQuery->all(),
            'pagination' => [
                'pageSize' => 100
            ],
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

        $names = OrderItem::find()
            ->from('order_item o')
            ->select([
                'CONCAT(g.name, "-", v.value) AS nameAndColor',
                'v.value',
                'v.good_id',
                'o.good_id',
                'o.qty'
            ])
            ->joinWith([
                'good g',
                'good.values v' => function ($query) {
                    return $query->andWhere(['=', 'characteristic_id', 1]);
                }
            ])
            ->groupBy('o.good_id')
            ->orderBy(['o.qty' => SORT_DESC])
            ->limit(20)
            ->asArray()->column();

        $quantities = OrderItem::find()
            ->select(['SUM(qty)', 'good_id'])
            ->groupBy('good_id')
            ->orderBy(['qty' => SORT_DESC])
            ->limit(20)
            ->asArray()->column();

        $colors = ColorHelper::getColors(count($quantities));

        return $this->render('credit', [
            'totalDebitActiveProvider' => $totalDebitActiveProvider,
            'names' => $names,
            'quantities' => $quantities,
            'colors' => $colors
        ]);
    }

    public function actionProfit()
    {
        $purchasesDate = Purchase::find()->select(['date_start'])->orderBy(['date_start' => SORT_ASC])->column();

        $calculation = [];
        foreach ($purchasesDate as $key => $date) {
            $dateStart = $date;
            $dateEnd = isset($purchasesDate[$key + 1]) ? $purchasesDate[$key + 1] : null;

            $sumReceipts = (new Query())
                ->from(['receipt'])
                ->select([
                    'SUM(receipt.total) AS totalSumReceipt',
                ])
                ->andWhere(['>', 'date', $dateStart])
                ->andFilterWhere(['<', 'date', $dateEnd])
                ->column();

            $sumOrders = (new Query())
                ->from(['order'])
                ->select([
                    'SUM(order.total) AS totalSumOrder',
                ])
                ->where(['payment' => Order::PAYMENT_PAYMENT])
                ->andWhere(['>', 'date', $dateStart])
                ->andFilterWhere(['<', 'date', $dateEnd])
                ->column();


            $calculation[$date]['totalSumReceipt'] = $sumReceipts[0];
            $calculation[$date]['totalSumOrder'] = $sumOrders[0];
            $calculation[$date]['profit'] = $calculation[$date]['totalSumOrder'] - $calculation[$date]['totalSumReceipt'];
        }

        $names = [];

        foreach ($calculation as $key => $calculate) {
            $names[] = \Yii::$app->formatter->asDate($key, 'php: m.Y');
        }

        $dataReceipts = [];
        foreach ($calculation as $key => $item) {
            $dataReceipts[] = isset($item['totalSumReceipt']) ? $item['totalSumReceipt'] : 0;
        }

        $dataOrders = [];
        foreach ($calculation as $key => $item) {
            $dataOrders[] = isset($item['totalSumOrder']) ? $item['totalSumOrder'] : 0;
        }

        $dataProfit = [];
        foreach ($calculation as $key => $item) {
            $dataProfit[] = isset($item['profit']) ? $item['profit'] : 0;
        }

        foreach ($calculation as $key => $item) {
            $datasets = [
                [
                    'label' => 'Закупка',
                    'backgroundColor' => 'brown',
                    'stack' => 'Stack 0',
                    'data' => $dataReceipts
                ],
                [
                    'label' => 'Оплаченые заказы',
                    'backgroundColor' => 'blue',
                    'stack' => 'Stack 1',
                    'data' => $dataOrders
                ],
                [
                    'label' => 'Выручка',
                    'backgroundColor' => 'green',
                    'stack' => 'Stack 3',
                    'data' => $dataProfit
                ],
            ];
        }

        return $this->render('profit', [
            'names' => $names,
            'datasets' => $datasets
        ]);
    }

}