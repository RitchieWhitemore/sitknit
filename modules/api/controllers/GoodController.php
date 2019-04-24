<?php

namespace app\modules\api\controllers;

use app\models\Good;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class GoodController extends ActiveController
{
    public $modelClass = 'app\models\Good';

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

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = new $this->modelClass;

        $query = $modelClass::find()->with('images', 'prices');
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