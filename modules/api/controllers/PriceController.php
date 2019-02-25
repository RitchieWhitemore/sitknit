<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 24.02.2019
 * Time: 13:16
 */

namespace app\modules\api\controllers;


use app\components\SetPrice;
use app\modules\trade\models\SetPriceAjaxForm;
use Yii;
use yii\rest\ActiveController;

class PriceController extends ActiveController
{
    public $modelClass = 'app\modules\trade\models\SetPriceAjaxForm';

    public function actionSetPrice()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new SetPriceAjaxForm();

        $session = Yii::$app->session;

        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post('SetPriceAjaxForm');

            if ($model->stringCsv) {
                $session->set('countCsv', $model->beginStep);
                $setPrice = new SetPrice($model);
                $setPrice->run();
            } else {
                return ['count' => 'Прайс загружен'];
            }
        }

        return ['count' => $session->get('countCsv')];
    }
}