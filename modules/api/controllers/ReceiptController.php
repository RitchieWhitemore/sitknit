<?php

namespace app\modules\api\controllers;


use app\core\entities\Document\Receipt;
use app\services\DocumentRepository;
use Yii;
use yii\rest\ActiveController;

class ReceiptController extends ActiveController
{
    public $modelClass = 'app\core\entities\Document\Receipt';

    public function actionSave()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();

        if (!$document = Receipt::findOne($requestParams['Receipt']['id'])) {
            $document = new Receipt();
        };

        $documentTable = json_decode($requestParams['documentTable']);

        $documentRepository = new DocumentRepository($document, $documentTable, $requestParams['Receipt']);

        return $documentRepository->save();

    }
}