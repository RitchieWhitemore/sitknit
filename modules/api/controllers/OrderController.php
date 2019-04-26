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
use app\services\DocumentRepository;
use Yii;
use yii\db\Exception;
use yii\rest\ActiveController;

class OrderController extends ActiveController
{
    public $modelClass = 'app\modules\trade\models\Order';

    public function actionSave()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();

        if (!$document = Order::findOne($requestParams['Order']['id'])) {
            $document = new Order();
        };
        $documentTable = json_decode($requestParams['documentTable']);

        $documentRepository = new DocumentRepository($document, $documentTable, $requestParams['Order']);

        return $documentRepository->save();

        /*$documentTableInitial = OrderItem::find()->where(['order_id' => $requestParams['Order']['id']])->all();

        foreach ($documentTableInitial as $index => $item) {
            foreach ($documentTable as $value) {
                if ($item['good_id'] == $value->good_id) {
                    unset($documentTableInitial[$index]);
                }
            }
        }

        $transaction = Order::getDb()->beginTransaction();
        try {

            if (count($documentTable) === 0) {
                throw new Exception('ошибка: ', ['error' =>
                                                     ['Ошибка: В документе должна быть хотя бы одна строка']
                ]);
            }

            if (!isset($document)) {
                $document = new Order();
            }
            $document->partner_id = $requestParams['Order']['partner_id'];
            $document->total = $requestParams['Order']['total'];
            $document->date = $requestParams['Order']['date'];
            $document->status = $requestParams['Order']['status'];
            $document->payment = $requestParams['Order']['payment'];
            if ($document->save()) {
                foreach ($documentTable as $item) {
                    $tableItem = OrderItem::find()->where(['order_id' => $document->id, 'good_id' => $item->good_id])->one();
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

            } else {
                throw new Exception('ошибка', $document->errors);
            }


            $transaction->commit();
            if (!$document->hasErrors() && strpos(Yii::$app->request->referrer, 'create')) {
                return ['status' => true, 'id' => $document->id];
            } else {
                return ['status' => true];
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
            return ['status' => false];
        }*/
    }
}