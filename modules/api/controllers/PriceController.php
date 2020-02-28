<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 24.02.2019
 * Time: 13:16
 */

namespace app\modules\api\controllers;


use app\components\price\ParsePriceListCSV;
use app\core\repositories\Shop\PriceRepository;
use app\modules\trade\models\SetPriceAjaxForm;
use Yii;
use yii\rest\ActiveController;

class PriceController extends ActiveController
{
    public $modelClass = 'app\core\entities\Shop\Price';

    public function actionSetPrice()
    {
        /* @var $form SetPriceAjaxForm */
        $form = new SetPriceAjaxForm();

        $session = Yii::$app->session;

        if ($form->load(Yii::$app->request->post())) {

            if ($form->stringPackCsv) {
                $session->set('countCsv', $form->beginStep);
                $setPrice = new ParsePriceListCSV($form, new PriceRepository());
                $setPrice->parse();
            } else {
                $session->remove('countCsv');
                return ['count' => 'Прайс загружен'];
            }
        }

        return ['count' => $session->get('countCsv')];
    }
}