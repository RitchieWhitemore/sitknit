<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 03.01.2019
 * Time: 22:22
 */

namespace app\controllers;

use app\models\Attribute;
use app\models\AttributeValue;
use app\models\Category;
use app\models\Good;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GoodsController extends Controller
{
    public function actionCatalog()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Category::find()->where(['active' => 1]),
            ]
        );
        return $this->render('catalog', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory($id)
    {
        $Category = Category::findOne($id);

        if (!isset($Category)) {
            throw new NotFoundHttpException();
        }

        $dataProvider = new ActiveDataProvider(
            [
                'query'      => Good::find()->where(['category_id' => $id, 'active' => 1])->with(['attributeValues', 'mainGood.attributeValues']),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]
        );

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'model'        => $Category,
        ]);
    }

    public function actionView($id)
    {
        $model = Good::find()->where(['id' => $id, 'active' => 1])->with(['attributeValues'])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if (isset($model->mainGood)) {
            $valuesMain = $model->mainGood->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
            $values = $model->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
        }
        else {
            $values = $model->getAttributeValues()->with('goodAttribute.unit')->indexBy('goodAttribute.name')->all();
            $valuesMain = $values;
        }


        return $this->render('good', [
            'model'      => $model,
            'values'     => $values,
            'valuesMain' => $valuesMain,
        ]);
    }
}