<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 03.01.2019
 * Time: 22:22
 */

namespace app\controllers;

use yii\web\Controller;

class GoodsController extends Controller
{
    public function actionCatalog()
    {
        return $this->render('catalog');
    }
}