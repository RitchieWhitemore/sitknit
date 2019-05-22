<?php

namespace app\modules\api\controllers;

use app\core\entities\Shop\Good\Good;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class GoodController extends ActiveController
{
    public $modelClass = 'app\core\entities\Shop\Good\Good';

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
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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

        $query = $modelClass::find()->with('images', 'prices');
        if (!empty($requestParams)) {
            $query->andWhere($requestParams);
        }

        $result = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);

        return $result;
    }

    public function actionList($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        /* @var $modelClass yii\db\BaseActiveRecord */
        $modelClass = new $this->modelClass;

        $query = $modelClass::find()->joinWith('values', 'prices')->addSelect(['*']);
        if (!empty($requestParams)) {
            $query->andFilterWhere(['or', ['like', 'name', $q], ['like', 'value', $q]]);
        }

        $query->limit(100);

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
        ]);
    }

    public function actionCategory($categoryId, $brandId)
    {
        if ($categoryId == 0) {
            $categoryId = null;
        }
        if ($brandId == 0) {
            $brandId = null;
        }

        $model = Good::find()->where(['category_id' => (int)$categoryId, 'brand_id' => (int)$brandId])->all();

        return $model;
    }

    public function actionGroupByName($categoryId, $brandId, $groupName)
    {
        if ($categoryId == 0) {
            $categoryId = null;
        }
        if ($brandId == 0) {
            $brandId = null;
        }

        $model = Good::find()->where(['category_id' => (int) $categoryId, 'brand_id' => (int) $brandId]);
        if ($groupName != 'undefined' && $groupName != 'Все группы') {
            $model->andWhere(['name' => $groupName]);
        };

        $model = $model->groupBy('name')->all();

        return $model;
    }

    public function actionDeleteMainGood($id)
    {
        $model = Good::findOne($id);
        $model->main_good_id = null;
    }
}