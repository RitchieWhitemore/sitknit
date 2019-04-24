<?php

namespace app\modules\api\controllers;


use app\modules\trade\models\Receipt;
use app\modules\trade\models\ReceiptItem;
use Yii;
use yii\db\Exception;
use yii\rest\ActiveController;

class ReceiptController extends ActiveController
{
    public $modelClass = 'app\modules\trade\models\Receipt';

    public function actionSave()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();

        $document = Receipt::findOne($requestParams['Receipt']['id']);
        $documentTable = json_decode($requestParams['documentTable']);
        $documentTableInitial = ReceiptItem::find()->where(['receipt_id' => $requestParams['Receipt']['id']])->all();

        foreach ($documentTableInitial as $index => $item) {
            foreach ($documentTable as $value) {
                if ($item['good_id'] == $value->good_id) {
                    unset($documentTableInitial[$index]);
                }
            }
        }

        $transaction = Receipt::getDb()->beginTransaction();
        try {

            if (!isset($document)) {
                $document = new Receipt();
            }
            $document->partner_id = $requestParams['Receipt']['partner_id'];
            $document->total = $requestParams['Receipt']['total'];
            $document->date = $requestParams['Receipt']['date'];

            if ($document->save()) {
                if (count($documentTable) === 0) {
                    throw new Exception('ошибка: ', ['error' =>
                                                         ['Ошибка: В документе должна быть хотя бы одна строка']
                    ]);
                }
                foreach ($documentTable as $item) {
                    $tableItem = ReceiptItem::find()->where(['receipt_id' => $document->id, 'good_id' => $item->good_id])->one();

                    if (!isset($tableItem)) {
                        $tableItem = new ReceiptItem();
                        $tableItem->receipt_id = $document->id;
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
        }
    }
}