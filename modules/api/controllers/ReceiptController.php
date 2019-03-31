<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 23.03.2019
 * Time: 14:09
 */

namespace app\modules\api\controllers;


use app\modules\trade\models\Receipt;
use app\modules\trade\models\ReceiptItem;
use Yii;
use yii\rest\ActiveController;

class ReceiptController extends ActiveController
{
    public $modelClass = 'app\modules\trade\models\Receipt';

    public function actionSave()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();

        $document = Receipt::findOne($requestParams['Receipt']['id']);
        $documentTable = json_decode($requestParams['documentTable']);
        $documentTableInitial = ReceiptItem::find()->where(['receipt_id' => $requestParams['Receipt']['id']])->with('good')->all();

        foreach ($documentTableInitial as $index => $item) {
            foreach ($documentTable as $value) {
                if ($item->good->article === $value->article) {
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
            $document->save();

            foreach ($documentTable as $item) {
                $tableItem = ReceiptItem::findOne($item->id);
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

            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
            return false;
        }
    }
}