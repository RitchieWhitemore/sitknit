<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 03.01.2019
 * Time: 22:22
 */

namespace app\controllers;

use app\models\Category;
use app\models\Good;
use yii\data\ActiveDataProvider;
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
                'query'      => Good::find()->where(['categoryId' => $id, 'active' => 1]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]
        );

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'model' => $Category,
        ]);
    }
}