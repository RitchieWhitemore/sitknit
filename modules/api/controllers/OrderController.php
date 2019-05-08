<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 23.03.2019
 * Time: 14:09
 */

namespace app\modules\api\controllers;

use app\modules\trade\models\Order;
use app\services\DocumentRepository;
use Yii;
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
    }
}