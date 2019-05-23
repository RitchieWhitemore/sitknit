<?php

namespace app\modules\api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use Yii;

class OrderItemController extends ActiveController
{
    public $modelClass = 'app\core\entities\Document\OrderItem';


    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete" и "create"
        unset($actions['delete'], $actions['create']);

        // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        if (isset($requestParams['expand'])) {
            unset($requestParams['expand']);
        }

        if (isset($requestParams['q'])) {
            unset($requestParams['q']);
        }


        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = new $this->modelClass;

        $query = $modelClass::find()->with('good');
        if (!empty($requestParams)) {
            $query->andWhere($requestParams);
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }
}