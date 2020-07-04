<?php


namespace app\modules\cart\widgets;


use app\modules\cart\models\Cart;
use yii\base\Widget;

class CartInfoWidget extends Widget
{
    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart, $config = [])
    {
        parent::__construct($config);
        $this->cart = $cart;
    }

    public function run()
    {
        $amount = $this->cart->getAmount();
        $totalSum = $this->cart->getTotalSum();

        return $this->render('info', compact('amount', 'totalSum'));
    }
}