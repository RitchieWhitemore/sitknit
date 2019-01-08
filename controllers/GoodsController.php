<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 03.01.2019
 * Time: 22:22
 */

namespace app\controllers;

use app\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

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
}