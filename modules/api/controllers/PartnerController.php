<?php
/**
 * Created by PhpStorm.
 * User: Lexx
 * Date: 23.02.2019
 * Time: 19:33
 */

namespace app\modules\api\controllers;


use yii\rest\ActiveController;

class PartnerController extends ActiveController
{
    public $modelClass = 'app\modules\trade\models\Partner';
}