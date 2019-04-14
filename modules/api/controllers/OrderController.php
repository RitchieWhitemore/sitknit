<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 23.03.2019
 * Time: 14:09
 */

namespace app\modules\api\controllers;

use app\modules\trade\models\Order;
use app\modules\trade\models\OrderItem;
use Yii;
use yii\rest\ActiveController;

class OrderController extends ActiveController
{
    public $modelClass = 'app\modules\trade\models\Order';

    public function actionSave()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();

        $document = Order::findOne($requestParams['Order']['id']);
        $documentTable = json_decode($requestParams['documentTable']);
        $documentTableInitial = OrderItem::find()->where(['order_id' => $requestParams['Order']['id']])->with('good')->all();

        foreach ($documentTableInitial as $index => $item) {
            foreach ($documentTable as $value) {
                if ($item->good->article === $value->article) {
                    unset($documentTableInitial[$index]);
                }
            }
        }

        $transaction = Order::getDb()->beginTransaction();
        try {

            if (!isset($document)) {
                $document = new Order();
            }
            $document->partner_id = $requestParams['Order']['partner_id'];
            $document->total = $requestParams['Order']['total'];
            $document->date = $requestParams['Order']['date'];
            $document->status = $requestParams['Order']['status'];
            $document->payment = $requestParams['Order']['payment'];
            $document->save();

            foreach ($documentTable as $item) {
                $tableItem = OrderItem::findOne($item->id);
                if (!isset($tableItem)) {
                    $tableItem = new OrderItem();
                    $tableItem->order_id = $document->id;
                    $tableItem->good_id = $item->good_id;
                }

                $tableItem->qty = $item->qty;
                $tableItem->price = $item->price;
                $tableItem->save();
            }

            foreach ($documentTableInitial as $item) {
                $item->delete();
            }

            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
            return false;
        }
    }
}