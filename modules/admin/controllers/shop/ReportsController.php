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