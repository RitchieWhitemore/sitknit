<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 06.03.2019
 * Time: 11:15
 */

namespace app\modules\api\controllers;


use app\models\Brand;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class BrandController extends ActiveController
{
    public $modelClass = 'app\models\Brand';

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

        /* @var $modelClass Brand */
        $modelClass = new $this->modelClass;

        $query = $modelClass::find()->select(['brand.*']);

        if (isset($requestParams['categoryId'])) {
            $query->inCategory($requestParams['categoryId']);
        }
       /* if (!empty($requestParams)) {
            $query->andWhere($requestParams);
        }*/

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