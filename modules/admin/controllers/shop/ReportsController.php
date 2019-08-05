<?php


namespace app\modules\admin\controllers\shop;


use app\core\entities\Document\OrderItem;
use app\core\entities\Document\ReceiptItem;
use app\core\readModels\Shop\RemainingReadRepository;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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

    public function actionRemaining()
    {
        $remaining = $this->remaining->getLastRemaining();

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
            ->select(['qty', 'good_id'])
            ->groupBy('good_id')
            ->orderBy(['qty' => SORT_DESC])
            ->limit(20)
            ->asArray()->column();

        $colors = [];
        for ($i = 0; $i <= count($quantities); $i++) {
            $colors[] = '#' . substr(md5(mt_rand()), 0, 6);
        }

        return $this->render('credit', [
            'totalDebitActiveProvider' => $totalDebitActiveProvider,
            'names' => $names,
            'quantities' => $quantities,
            'colors' => $colors
        ]);
    }
}