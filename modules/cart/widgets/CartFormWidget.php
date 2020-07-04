<?php


namespace app\modules\cart\widgets;


use app\modules\cart\forms\CartForm;
use yii\base\Widget;

class CartFormWidget extends Widget
{
    public $goodId;

    public function run()
    {
        $model = new CartForm(['goodId' => $this->goodId]);
        return $this->render('form', compact('model'));
    }
}