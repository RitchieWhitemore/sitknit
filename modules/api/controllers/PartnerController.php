<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 23.02.2019
 * Time: 19:33
 */

namespace app\modules\api\controllers;


use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class PartnerController extends ActiveController
{
    public $modelClass = 'app\modules\trade\models\Partner';

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

        $query = $modelClass::find();
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